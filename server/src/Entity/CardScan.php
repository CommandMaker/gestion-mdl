<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use App\Controller\CreateCardScanController;
use App\Controller\QueryCardScanController;
use App\Repository\CardScanRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: CardScanRepository::class)]
#[ApiResource(
    operations: [
        new GetCollection(
            name: 'get_history',
            uriTemplate: '/card_scans/history',
            controller: QueryCardScanController::class,
        ),
        new Get,
        new Post(
            name: 'create',
            controller: CreateCardScanController::class
        ),
    ],
    normalizationContext: [
        'groups' => ['card_scan:read', 'st:read'],
    ],
    denormalizationContext: [
        'groups' => ['card_scan:write'],
    ]
)]
class CardScan
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'cardScans')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['card_scan:read'])]
    private ?User $user = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE)]
    #[Groups(['card_scan:read', 'card_scan:write'])]
    private ?\DateTimeImmutable $date = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['card_scan:read', 'card_scan:write'])]
    private ?TimePeriod $timePeriod = null;

    #[Groups(['card_scan:write'])]
    private ?string $code = null;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getDate(): ?\DateTimeImmutable
    {
        return $this->date;
    }

    public function setDate(\DateTimeImmutable $date): static
    {
        $this->date = $date;

        return $this;
    }

    public function getTimePeriod(): ?TimePeriod
    {
        return $this->timePeriod;
    }

    public function setTimePeriod(?TimePeriod $timePeriod): static
    {
        $this->timePeriod = $timePeriod;

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
}
