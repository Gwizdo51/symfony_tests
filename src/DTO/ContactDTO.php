<?php

namespace App\DTO;

use Symfony\Component\Validator\Constraints as Assert;

class ContactDTO {
    #[Assert\NotBlank]
    #[Assert\Length(
        min: 3,
        max: 25,
        minMessage: 'The name must be at least 3 characters long.',
        maxMessage: 'The name cannot be more than 25 characters.'
    )]
    public string $name;

    #[Assert\NotBlank]
    #[Assert\Email(
        message: 'The email "{{ value }}" is not a valid email.',
    )]
    public string $email;

    #[Assert\NotBlank]
    public string $destination;

    #[Assert\NotBlank]
    #[Assert\Length(min: 10, max: 1000)]
    public string $message;
}
