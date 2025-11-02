<?php declare(strict_types=1);
namespace App\Entity;

class Post
{
    private ?int $id;
    private string $title;
    private string $body;
    private ?string $image;
    private \DateTimeImmutable $createdAt;

    public function __construct(
        ?int $id,
        string $title,
        string $body,
        ?string $image,
        \DateTimeImmutable $createdAt
    ) {
        $this->id = $id;
        $this->title = $title;
        $this->body = $body;
        $this->image = $image;
        $this->createdAt = $createdAt;
    }

    /**
     * Factory method for creating a new Post instance.
     */
    public static function create(
        string $title,
        string $body,
        ?string $image = null,
        ?int $id = null,
        ?\DateTimeImmutable $createdAt = null
    ): self {
        return new self(
            $id,
            $title,
            $body,
            $image,
            $createdAt ?? new \DateTimeImmutable()
        );
    }

    // --- Getters ---
    public function getId(): ?int { return $this->id; }
    public function getTitle(): string { return $this->title; }
    public function getBody(): string { return $this->body; }
    public function getImage(): ?string { return $this->image; }
    public function getCreatedAt(): \DateTimeImmutable { return $this->createdAt; }

    // --- Setters ---
    public function setId(?int $id): void { $this->id = $id; }
    public function setTitle(string $title): void { $this->title = $title; }
    public function setBody(string $body): void { $this->body = $body; }
    public function setImage(?string $image): void { $this->image = $image; }
    public function setCreatedAt(\DateTimeImmutable $createdAt): void { $this->createdAt = $createdAt; }
}
