<?php declare(strict_types=1);

namespace App\ApiResource\Badge;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;

#[ApiResource(
    operations: [
        // new GetCollection(
        //     uriTemplate: '/badge',
        //     openapi: new Operation(
        //         summary: 'Get the list of available badge systems',
        //         // description: 'Get a specific company from the badge system specified',
        //         tags: ['Badge'],
        //     ),
        // ),
    ],
)]
final class BadgeSystem {

    public function __construct(
        #[ApiProperty(identifier: true)]
        public readonly ?string $name = null,
    ) {}
}
