<?php declare(strict_types=1);
namespace App\Entity;

use Careminate\EntityManager\Entity;

class Comment extends Entity
{
    private ?int $id;
    private int $postId;
    private string $author;
    private string $content;
    private \DateTimeImmutable $createdAt;

    public function __construct(
        ?int $id,
        int $postId,
        string $author,
        string $content,
        \DateTimeImmutable $createdAt
    ) {
        $this->id = $id;
        $this->postId = $postId;
        $this->author = $author;
        $this->content = $content;
        $this->createdAt = $createdAt;
    }

    public static function create(int $postId, string $author, string $content, ?int $id = null, ?\DateTimeImmutable $createdAt = null): self
    {
        return new self($id, $postId, $author, $content, $createdAt ?? new \DateTimeImmutable());
    }

    public function getId(): ?int { return $this->id; }
    public function getPostId(): int { return $this->postId; }
    public function getAuthor(): string { return $this->author; }
    public function getContent(): string { return $this->content; }
    public function getCreatedAt(): \DateTimeImmutable { return $this->createdAt; }
}
