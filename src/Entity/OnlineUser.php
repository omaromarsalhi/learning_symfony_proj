<?php

namespace App\Entity;

use App\Repository\OnlineUserRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OnlineUserRepository::class)]
class OnlineUser
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(inversedBy: 'no', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $userId = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Chat $idLastMsgToGet = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserId(): ?User
    {
        return $this->userId;
    }

    public function setUserId(User $userId): static
    {
        $this->userId = $userId;

        return $this;
    }

    public function getIdLastMsgToGet(): ?Chat
    {
        return $this->idLastMsgToGet;
    }

    public function setIdLastMsgToGet(Chat $idLastMsgToGet): static
    {
        $this->idLastMsgToGet = $idLastMsgToGet;

        return $this;
    }
}
