<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

class APIJsonLoginController extends AbstractController
{
    #[Route('/login', name: 'login.json', methods: 'POST')]
    public function index(): JsonResponse
    {
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
