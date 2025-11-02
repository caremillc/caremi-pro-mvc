<?php declare (strict_types = 1);
namespace App\Repository;

use App\Entity\Post;
use Doctrine\DBAL\Connection;

class PostMapper
{
    public function __construct(private Connection $connection)
    {
    }

    public function save(Post $post): void
    {
        $stmt = $this->connection->prepare("
            INSERT INTO posts (title, body, image, created_at)
            VALUES (:title, :body, :image, :created_at)
        ");

        $stmt->bindValue(':title', $post->getTitle());
        $stmt->bindValue(':body', $post->getBody());
        $stmt->bindValue(':image', $post->getImage()); // save image filename
        $stmt->bindValue(':created_at', $post->getCreatedAt()->format('Y-m-d H:i:s'));

        $stmt->executeStatement();

        $id = $this->connection->lastInsertId();
        $post->setId((int) $id);
    }

    public function update(Post $post): void
    {
        $stmt = $this->connection->prepare("
            UPDATE posts
            SET title = :title,
                body = :body,
                image = :image
            WHERE id = :id
        ");

        $stmt->bindValue(':title', $post->getTitle());
        $stmt->bindValue(':body', $post->getBody());
        $stmt->bindValue(':image', $post->getImage());
        $stmt->bindValue(':id', $post->getId());

        $stmt->executeStatement();
    }
}
