<?php

namespace App\Controller;

use App\Entity\FoyerOpenHistory;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

class APIJsonLoginController extends AbstractController
{
    #[Route('/login', name: 'login.json', methods: 'POST')]
    public function index(EntityManagerInterface $em): JsonResponse
    {
        $history = new FoyerOpenHistory();
        $history->setUser($this->getUser());

        $em->persist($history);
        $em->flush();

        return $this->json([]);
    }

    #[Route('/api/logout', name: 'login.logout')]
    public function logout(): void {}

    #[Route('/api/me', name: 'login.user')]
    public function user(): JsonResponse
    {
        return $this->json($this->getUser());
    }
}
