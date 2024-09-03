<?php

namespace App\EventListener;

use App\Exception\PasswordMissingException;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\PasswordHasher\Hasher\PasswordHasherFactory;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;

final class RequestListener
{
    public function __construct(
        private string $masterPassword,
    ) {}

    #[AsEventListener(event: KernelEvents::REQUEST)]
    public function onKernelRequest(RequestEvent $event): void
    {
        $request = $event->getRequest();

        $ignoredRoutes = [
            '/api/card_scans',
            '/api/card_scans/history',
        ];

        if ($request->getMethod() !== 'GET' && !in_array($request->getRequestUri(), $ignoredRoutes)) {
            $password = $request->getPayload()->getString('master_password');

            if ($password === '' && $request->query->getString('master_password') === '') {
                throw new PasswordMissingException('This route needs a password to be accessed');
            }

            if ($request->query->getString('master_password') !== '') {
                $password = $request->query->getString('master_password');
            }

            $factory = new PasswordHasherFactory([
                'default' => ['algorithm' => 'auto'],
            ]);

            $hasher = $factory->getPasswordHasher('default');

            if (!$hasher->verify($this->masterPassword, $password)) {
                throw new BadCredentialsException('The password is incorrect');
            }
        }
    }
}
