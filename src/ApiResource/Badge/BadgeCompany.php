<?php declare(strict_types=1);

namespace App\ApiResource\Badge;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Link;
use ApiPlatform\OpenApi\Model\Operation;
use App\State\Badge\CompanyProvider;
use Symfony\Component\Serializer\Attribute\Groups;

#[ApiResource(
    operations: [
        new Get(
            uriTemplate: '/badge/{system}/companies/{id}',
            uriVariables: [
                'system' => new Link(
                    description: 'The system to get companies from',
                    fromClass: BadgeSystem::class,
                    toProperty: 'system',
                ),
                'id' => new Link(
                    fromClass: BadgeCompany::class,
                ),
            ],
            openapi: new Operation(
                summary: 'Get a specific company',
                description: 'Get a specific company from the badge system specified',
                tags: ['Badge'],
            ),
            provider: CompanyProvider::class,
        ),
        new GetCollection(
            uriTemplate: '/badge/{system}/companies',
            uriVariables: [
                'system' => new Link(
                    description: 'The system to get companies from',
                    fromClass: BadgeSystem::class,
                    toProperty: 'system',
                ),
            ],
            openapi: new Operation(
                summary: 'Get the list of companies',
                description: 'Get the list of companies from the badge system specified',
                tags: ['Badge'],
            ),
            provider: CompanyProvider::class,
        ),
    ],
    normalizationContext: ['groups' => ['badge-company:read']],
)]
final class BadgeCompany {
    public function __construct(
        #[ApiProperty(identifier: true)]
        #[Groups(['badge-company:read'])]
        public readonly ?int $id = null,
        #[Groups(['badge-company:read'])]
        public ?string $name = null,
        public ?BadgeSystem $system = null,
    ) {}
}
