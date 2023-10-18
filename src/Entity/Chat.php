<?php

namespace App\Entity;

use App\Repository\ChatRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ChatRepository::class)]
class Chat
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $body = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $sent_at = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $recived_at = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $senderId = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $reciverId = null;

    #[ORM\Column]
    private ?bool $viewedOrNot = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBody(): ?string
    {
        return $this->body;
    }

    public function setBody(?string $body): static
    {
        $this->body = $body;

        return $this;
    }

    public function getSentAt(): ?\DateTimeImmutable
    {
        return $this->sent_at;
    }

    public function setSentAt(\DateTimeImmutable $sent_at): static
    {
        $this->sent_at = $sent_at;

        return $this;
    }

    public function getRecivedAt(): ?\DateTimeImmutable
    {
        return $this->recived_at;
    }

    public function setRecivedAt(\DateTimeImmutable $recived_at): static
    {
        $this->recived_at = $recived_at;

        return $this;
    }

    public function getSenderId(): ?User
    {
        return $this->senderId;
    }

    public function setSenderId(?User $senderId): static
    {
        $this->senderId = $senderId;

        return $this;
    }

    public function getReciverId(): ?User
    {
        return $this->reciverId;
    }

    public function setReciverId(?User $reciverId): static
    {
        $this->reciverId = $reciverId;

        return $this;
    }

    public function isViewedOrNot(): ?bool
    {
        return $this->viewedOrNot;
    }

    public function setViewedOrNot(bool $viewedOrNot): static
    {
        $this->viewedOrNot = $viewedOrNot;

        return $this;
    }
}
