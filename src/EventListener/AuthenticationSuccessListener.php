<?php

namespace App\EventListener;

use App\Entity\User;
use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationSuccessEvent;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;

final class AuthenticationSuccessListener
{
    public function __construct(private LoggerInterface $logger) {}

    #[AsEventListener(event: 'lexik_jwt_authentication.on_authentication_success')]
    public function onAuthenticationSuccessEvent(AuthenticationSuccessEvent $event): void {
        $this->logger->debug('onAuthenticationSuccessEvent called');
        $data = $event->getData();
        $user = $event->getUser();
        if (!$user instanceof User) {
            return;
        }
        $data['user'] = [
            'id' => $user->getId(),
            'username' => $user->getUsername(),
        ];
        $event->setData($data);
    }
}
