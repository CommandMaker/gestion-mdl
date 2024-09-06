<?php

namespace App\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

/**
 * @implements ProcessorInterface<User, User|void>
 */
final readonly class PasswordHasherProcessor implements ProcessorInterface
{
    public function __construct(
        /** @var ProcessorInterface<User, User|void> */
        private ProcessorInterface $processor,
        private UserPasswordHasherInterface $hasher
    )
    {}

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): User|null
    {
        if (!$data->getPassword()) {
            return $this->processor->process($data, $operation, $uriVariables, $context);
        }

        $hashedPassword = $this->hasher->hashPassword(
            $data,
            $data->getPassword()
        );
        $data->setPassword($hashedPassword);
        $data->eraseCredentials();

        return $this->processor->process($data, $operation, $uriVariables, $context);
    }
}
