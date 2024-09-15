<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use App\Controller\DumpCardController;
use App\Repository\UserRepository;
use App\State\PasswordHasherProcessor;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[UniqueEntity(['code'])]
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
        new GetCollection(
            paginationEnabled: false
        ),
        new Post(
            processor: PasswordHasherProcessor::class
        ),
        new Get,
        new Patch,
        new Delete,
        new Get(
            controller: DumpCardController::class,
            name: 'card_dump',
            uriTemplate: '/users/{id}/card',
            description: 'Create the user\'s card'
        ),
    ]
)]
class User implements PasswordAuthenticatedUserInterface, UserInterface
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

    /**
     * @var list<string>
     */
    #[ORM\Column]
    private array $roles = ['ROLE_USER'];

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['user:write'])]
    private ?string $password = null;

    #[ORM\ManyToOne(fetch: 'EAGER')]
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

    /**
     * @var Collection<int, Sanction>
     */
    #[ORM\OneToMany(targetEntity: Sanction::class, mappedBy: 'user', orphanRemoval: true)]
    private Collection $sanctions;

    #[ORM\Column(type: Types::DATE_IMMUTABLE)]
    #[Groups(['user:read', 'card_scan:read'])]
    private \DateTimeImmutable $createdAt;

    public function __construct()
    {
        $this->cardScans = new ArrayCollection;
        $this->sanctions = new ArrayCollection;

        $this->roles = ['ROLE_USER'];
        $this->createdAt = new \DateTimeImmutable;
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
        $this->firstname = mb_strtoupper(mb_substr($firstname, 0, 1)) . mb_substr($firstname, 1);

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): static
    {
        $this->lastname = mb_strtoupper($lastname);

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

    /**
     * @return Collection<int, Sanction>
     */
    public function getSanctions(): Collection
    {
        return $this->sanctions;
    }

    public function addSanction(Sanction $sanction): static
    {
        if (!$this->sanctions->contains($sanction)) {
            $this->sanctions->add($sanction);
            $sanction->setUser($this);
        }

        return $this;
    }

    public function removeSanction(Sanction $sanction): static
    {
        if ($this->sanctions->removeElement($sanction)) {
            // set the owning side to null (unless already changed)
            if ($sanction->getUser() === $this) {
                $sanction->setUser(null);
            }
        }

        return $this;
    }

    public function getRoles(): array
    {
        return $this->roles;
    }

    public function eraseCredentials(): void {}

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(?string $password): static
    {
        $this->password = $password;

        return $this;
    }

    public function getUserIdentifier(): string
    {
        return $this->code ?? '';
    }

    #[Groups(['user:read', 'card_scan:read'])]
    public function getSubscriptionValidity(): bool
    {
        if ($this->getSubscriptionType() === null) {
            return false;
        }

        if ($this->getSubscriptionType()->getDuration() === null) {
            return true;
        }

        $interval = \DateInterval::createFromDateString($this->getSubscriptionType()->getDuration());

        if ($this->createdAt->add($interval ?: new \DateInterval('')) >= new \DateTimeImmutable) {
            return true;
        }

        return false;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $created_at): static
    {
        $this->createdAt = $created_at;

        return $this;
    }
}
