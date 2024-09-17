<?php

namespace App\Entity;

use ApiPlatform\Doctrine\Orm\Filter\DateFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use App\Repository\FoyerOpenHistoryRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: FoyerOpenHistoryRepository::class)]
#[ApiResource(
    operations: [
        new GetCollection()
    ],
    normalizationContext: [
        'groups' => [
            'foh:read',
            'user:read'
        ]
    ]
)]
#[ApiFilter(DateFilter::class, properties: ['date'])]
class FoyerOpenHistory
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    #[Groups(['foh:read'])]
    private ?\DateTimeImmutable $date = null;

    #[ORM\ManyToOne(inversedBy: 'foyerOpenHistories')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['foh:read'])]
    private ?User $user = null;

    public function __construct()
    {
        $this->setDate(new \DateTimeImmutable());
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeImmutable
    {
        return $this->date;
    }

    public function setDate(\DateTimeImmutable $date): static
    {
        $this->date = $date;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }
}
