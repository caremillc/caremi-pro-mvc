<?php declare(strict_types=1);

namespace App\Repository;

use App\Entity\Comment;
use Doctrine\DBAL\Connection;
use Careminate\Exceptions\NotFoundException;

class CommentRepository
{
    public function __construct(private Connection $connection) {}

    /**
     * Retrieve all comments for a given post
     */
    public function findByPost(int $postId): array
    {
        $rows = $this->connection->createQueryBuilder()
            ->select('id', 'post_id', 'author', 'content', 'created_at')
            ->from('comments')
            ->where('post_id = :post_id')
            ->setParameter('post_id', $postId)
            ->orderBy('created_at', 'ASC')
            ->executeQuery()
            ->fetchAllAssociative();

        return array_map(fn($row) => $this->mapRowToComment($row), $rows);
    }

    /**
     * Find a single comment by ID
     */
    public function findById(int $id): ?Comment
    {
        $row = $this->connection->createQueryBuilder()
            ->select('id', 'post_id', 'author', 'content', 'created_at')
            ->from('comments')
            ->where('id = :id')
            ->setParameter('id', $id)
            ->executeQuery()
            ->fetchAssociative();

        return $row ? $this->mapRowToComment($row) : null;
    }

    /**
     * Create a new comment
     */
    public function create(int $postId, string $author, string $content): Comment
    {
        $now = new \DateTimeImmutable();

        $this->connection->insert('comments', [
            'post_id' => $postId,
            'author' => $author,
            'content' => $content,
            'created_at' => $now->format('Y-m-d H:i:s'),
        ]);

        $id = (int) $this->connection->lastInsertId();

        return new Comment($id, $postId, $author, $content, $now);
    }

    /**
     * Delete a comment
     */
    public function delete(int $id): bool
    {
        return (bool) $this->connection->delete('comments', ['id' => $id]);
    }

    /**
     * Map a database row to a Comment entity
     */
    private function mapRowToComment(array $row): Comment
    {
        return new Comment(
            (int) $row['id'],
            (int) $row['post_id'],
            $row['author'],
            $row['content'],
            new \DateTimeImmutable($row['created_at'])
        );
    }
}
