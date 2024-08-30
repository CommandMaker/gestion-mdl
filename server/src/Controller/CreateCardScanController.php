<?php

namespace App\Controller;

use App\Entity\CardScan;
use App\Exception\UserNotFoundException;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CreateCardScanController extends AbstractController
{
    public function __invoke(CardScan $cardScan, UserRepository $repository): CardScan
    {
        /** @var User */
        $user = $repository->findOneBy(['code' => $cardScan->getCode()]);

        if (!$user)
            throw new UserNotFoundException(sprintf('User with code "%s" does not exists.', $cardScan->getCode()));

        $cardScan->setUser($user);

        return $cardScan;
    }
}
