<?php

namespace App\Controller;

use App\Core\Card\CardGenerator;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class DumpCardController extends AbstractController
{
    #[Route('/api/users/card/{id}', name: 'dump_card', requirements: ['id' => '\d+'])]
    public function dumpCard(User $user, CardGenerator $generator): Response
    {
        $response = new Response(base64_decode($generator->generateCard($user)));
        $response->headers->set('Content-Type', 'image/jpeg');

        return $response;
    }

    #[Route('/api/phpinfo')]
    public function info()
    {
        return phpinfo();
    }
}
