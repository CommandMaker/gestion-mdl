<?php

namespace App\Controller\Sanction;

use App\Entity\Sanction;
use App\Entity\User;
use App\Exception\UserNotFoundException;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\Collection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class QuerySanctionsController extends AbstractController
{
    /**
     * @param Request $request
     *
     * @return Sanction[]|Collection<int, Sanction>
     */
    public function __invoke(Request $request, UserRepository $repo): mixed
    {
        $id = $request->query->getInt('userId');

        if (!$id)
            throw new UserNotFoundException(sprintf('You must specify a user id'));

        /** @var User */
        $user = $repo->find($id);

        if ($user == null)
            throw new UserNotFoundException('User with id ' . $id . ' cannot be found');

        return $user->getSanctions();
    }
}
