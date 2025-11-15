<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

#[\Attribute(\Attribute::TARGET_PROPERTY | \Attribute::TARGET_METHOD | \Attribute::IS_REPEATABLE)]
final class BanWord extends Constraint {
    // You can use #[HasNamedArguments] to make some constraint options required.
    // All configurable options must be passed to the constructor.
    public function __construct(
        // public string $message = 'The string "{{ value }}" contains an illegal character: it can only contain letters or numbers.',
        public string $message = 'This contains a banned word ("{{ bannedWord }}").',
        public array $bannedWords = ['spam', 'viagra'],
        public string $mode = 'strict',
        ?array $groups = null,
        mixed $payload = null
    ) {
        parent::__construct([], $groups, $payload);
    }
}
