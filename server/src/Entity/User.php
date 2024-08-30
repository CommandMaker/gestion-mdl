<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
#[ApiResource(
    normalizationContext: [
        'groups' => [
            'user:read',
            'st:read',
        ],
    ],
    denormalizationContext: [
        'groups' => [
            'user:write',
        ],
    ],
    operations: [
        new GetCollection,
        new Post,
        new Patch,
        new Delete,
    ]
)]
class User
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['user:read', 'card_scan:read', 'user:write'])]
    private ?string $firstname = null;

    #[ORM\Column(length: 255)]
    #[Groups(['user:read', 'card_scan:read', 'user:write'])]
    private ?string $lastname = null;

    #[ORM\Column(length: 255)]
    #[Groups(['user:read', 'card_scan:read', 'user:write'])]
    private ?string $code = null;

    #[ORM\Column(length: 255)]
    #[Groups(['user:read', 'card_scan:read', 'user:write'])]
    private ?string $gender = null;

    #[ORM\Column(length: 255)]
    #[Groups(['user:read', 'card_scan:read', 'user:write'])]
    private ?string $grade = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['user:read', 'card_scan:read', 'user:write'])]
    private ?SubscriptionType $subscriptionType = null;

    #[ORM\Column(options: ['default' => false])]
    #[Groups(['user:read', 'user:write'])]
    private ?bool $isAdmin = false;

    /**
     * @var Collection<int, CardScan>
     */
    #[ORM\OneToMany(targetEntity: CardScan::class, mappedBy: 'user', orphanRemoval: true)]
    private Collection $cardScans;

    public function __construct()
    {
        $this->cardScans = new ArrayCollection;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): static
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): static
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): static
    {
        $this->code = $code;

        return $this;
    }

    public function getGender(): ?string
    {
        return $this->gender;
    }

    public function setGender(string $gender): static
    {
        $this->gender = $gender;

        return $this;
    }

    public function getGrade(): ?string
    {
        return $this->grade;
    }

    public function setGrade(string $grade): static
    {
        $this->grade = $grade;

        return $this;
    }

    public function getSubscriptionType(): ?SubscriptionType
    {
        return $this->subscriptionType;
    }

    public function setSubscriptionType(?SubscriptionType $subscriptionType): static
    {
        $this->subscriptionType = $subscriptionType;

        return $this;
    }

    public function getIsAdmin(): ?bool
    {
        return $this->isAdmin;
    }

    public function setIsAdmin(bool $isAdmin): static
    {
        $this->isAdmin = $isAdmin;

        return $this;
    }

    /**
     * @return Collection<int, CardScan>
     */
    public function getCardScans(): Collection
    {
        return $this->cardScans;
    }

    public function addCardScan(CardScan $cardScan): static
    {
        if (!$this->cardScans->contains($cardScan)) {
            $this->cardScans->add($cardScan);
            $cardScan->setUser($this);
        }

        return $this;
    }

    public function removeCardScan(CardScan $cardScan): static
    {
        if ($this->cardScans->removeElement($cardScan)) {
            // set the owning side to null (unless already changed)
            if ($cardScan->getUser() === $this) {
                $cardScan->setUser(null);
            }
        }

        return $this;
    }
}
