<?php

namespace App\Controller;

use App\Core\Card\CardGenerator;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class DumpCardController extends AbstractController
{
    /* #[Route('/api/users/card/{id}', name: 'dump_card', requirements: ['id' => '\d+'])] */
    public function __invoke(User $user, CardGenerator $generator): Response
    {
        $response = new Response(base64_decode($generator->generateCard($user)));
        $response->headers->set('Content-Type', 'image/jpeg');

        return $response;
    }
}
