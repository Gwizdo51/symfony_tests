<?php declare(strict_types=1);

namespace App\ApiResource\Badge;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Link;
use ApiPlatform\OpenApi\Model\Operation;
use App\State\Badge\BadgeSystemProvider;

#[ApiResource(
    operations: [
        new GetCollection(
            uriTemplate: '/badges',
            openapi: new Operation(
                summary: 'Get the list of available badge systems',
                description: 'Get the list of available badge systems',
                tags: ['Badge'],
            ),
            provider: BadgeSystemProvider::class,
        ),
        new Get(
            uriTemplate: '/badges/{system}',
            uriVariables: [
                'system' => new Link(),
            ],
            openapi: new Operation(
                summary: 'Get a specific badge system',
                description: 'Get a specific badge system',
                tags: ['Badge'],
            ),
            provider: BadgeSystemProvider::class,
        ),
    ],
)]
final class BadgeSystem {
    public function __construct(
        #[ApiProperty(identifier: true)]
        public readonly ?string $name = null,
    ) {}
}
