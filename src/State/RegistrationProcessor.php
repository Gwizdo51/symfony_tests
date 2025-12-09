<?php

namespace App\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Entity\User;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class RegistrationProcessor implements ProcessorInterface {
        public function __construct(
            #[Autowire(service: 'api_platform.doctrine.orm.state.persist_processor')]
            private ProcessorInterface $persistProcessor,
            private UserPasswordHasherInterface $passwordHasher,
        ) {}

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): mixed {
        if ($data instanceof User) {
            $hashedPassword = $this->passwordHasher->hashPassword(
                $data,
                $data->plainPassword,
            );
            $data->setPassword($hashedPassword);
            $data->eraseCredentials();
        }

        return $this->persistProcessor->process($data, $operation, $uriVariables, $context);
    }
}
