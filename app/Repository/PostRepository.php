<?php declare(strict_types=1);
namespace App\Repository;

use App\Entity\Post;
use Doctrine\DBAL\Connection;
use Careminate\Exceptions\NotFoundException;

class PostRepository
{
    public function __construct(private Connection $connection) {}

    public function all(): array
    {
        $rows = $this->connection->createQueryBuilder()
            ->select('id', 'title', 'body', 'image', 'created_at')
            ->from('posts')
            ->orderBy('created_at', 'DESC')
            ->executeQuery()
            ->fetchAllAssociative();

        return array_map(fn($row) => $this->mapRowToPost($row), $rows);
    }

    public function findById(int $id): ?Post
    {
        $row = $this->connection->createQueryBuilder()
            ->select('id', 'title', 'body', 'image', 'created_at')
            ->from('posts')
            ->where('id = :id')
            ->setParameter('id', $id)
            ->executeQuery()
            ->fetchAssociative();

        return $row ? $this->mapRowToPost($row) : null;
    }

    public function findOrFail(int $id): Post
    {
        $post = $this->findById($id);

        if (!$post) {
            throw new NotFoundException("Post with ID {$id} not found.");
        }

        return $post;
    }

    public function create(string $title, string $body, ?string $image = null): Post
    {
        $now = new \DateTimeImmutable();

        $this->connection->insert('posts', [
            'title' => $title,
            'body' => $body,
            'image' => $image,
            'created_at' => $now->format('Y-m-d H:i:s'),
        ]);

        $id = (int) $this->connection->lastInsertId();

       return Post::create($title, $body, $image, $id, $now);
    }

    public function update(int $id, string $title, string $body, ?string $image = null): bool
    {
        return (bool) $this->connection->update('posts', [
            'title' => $title,
            'body' => $body,
            'image' => $image,
        ], ['id' => $id]);
    }

    public function delete(int $id): bool
    {
        return (bool) $this->connection->delete('posts', ['id' => $id]);
    }

    private function mapRowToPost(array $row): Post
    {
        return Post::create(
            id: (int) $row['id'],
            title: $row['title'],
            body: $row['body'],
            image: $row['image'] ?? null,
            createdAt: new \DateTimeImmutable($row['created_at'])
        );
    }
}
