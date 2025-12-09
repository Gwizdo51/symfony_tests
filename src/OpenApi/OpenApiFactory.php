<?php

namespace App\OpenApi;

use ApiPlatform\OpenApi\Factory\OpenApiFactoryInterface;
use ApiPlatform\OpenApi\Model\Operation;
use ApiPlatform\OpenApi\Model\PathItem;
use ApiPlatform\OpenApi\Model\RequestBody;
use ApiPlatform\OpenApi\OpenApi;
use Psr\Log\LoggerInterface;
use ArrayObject;
use Symfony\Component\DependencyInjection\Attribute\AsDecorator;

// priority at "-1" to overwrite the one from the library
#[AsDecorator(decorates: 'api_platform.openapi.factory', priority: -1)]
class OpenApiFactory implements OpenApiFactoryInterface {
    public function __construct(
        private OpenApiFactoryInterface $decorated,
        private LoggerInterface $logger,
    ) {}

    public function __invoke(array $context = []): OpenApi {
        $openApi = ($this->decorated)($context);

        // Auth schemas

        $schemas = $openApi->getComponents()->getSchemas();

        // credentials
        $schemas['AuthInput'] = new ArrayObject([
            'type' => 'object',
            'properties' => [
                'username' => [
                    'type' => 'string',
                    'example' => 'user1234',
                ],
                'password' => [
                    'type' => 'string',
                    'example' => 'password1234',
                ],
            ],
        ]);

        $schemas['RefreshInput'] = new ArrayObject([
            'type' => 'object',
            'properties' => [
                'refresh_token' => [
                    'type' => 'string',
                    'example' => 'f4a5...',
                ],
            ],
        ]);

        // JWT token
        $schemas['AuthOutput'] = new ArrayObject([
            'type' => 'object',
            'properties' => [
                'token' => [
                    'type' => 'string',
                    'readOnly' => true,
                ],
                'refresh_token' => [
                    'type' => 'string',
                    'readOnly' => true,
                ],
                'user' => [
                    'type' => 'object',
                    'properties' => [
                        'id' => ['type' => 'integer'],
                        'username' => ['type' => 'string'],
                    ]
                ]
            ],
        ]);

        // Auth paths

        $paths = $openApi->getPaths();

        // login endpoint
        $loginPath = new PathItem(
            ref: 'JWT token',
            post: new Operation(
                operationId: 'postLoginItem',
                tags: ['Auth'],
                responses: [
                    '200' => [
                        'description' => 'Authentication successful',
                        'content' => [
                            'application/json' => [
                                'schema' => [
                                    '$ref' => '#/components/schemas/AuthOutput',
                                ],
                            ],
                        ],
                    ],
                ],
                summary: 'Create a user JWT token',
                requestBody: new RequestBody(
                    description: 'The credentials of the user',
                    content: new ArrayObject([
                        'application/json' => [
                            'schema' => [
                                '$ref' => '#/components/schemas/AuthInput',
                            ],
                        ],
                    ]),
                ),
            ),
        );
        $paths->addPath('/api/auth', $loginPath);

        // refresh token endpoint
        $refreshPath = new PathItem(
            ref: 'refresh JWT token',
            post: new Operation(
                operationId: 'postRefreshTokenItem',
                tags: ['Auth'],
                responses: [
                    '200' => [
                        'description' => 'Token refresh successful',
                        'content' => [
                            'application/json' => [
                                'schema' => [
                                    '$ref' => '#/components/schemas/AuthOutput',
                                ],
                            ],
                        ],
                    ],
                ],
                summary: 'Refresh the JWT token',
                requestBody: new RequestBody(
                    description: 'The credentials of the user',
                    content: new ArrayObject([
                        'application/json' => [
                            'schema' => [
                                '$ref' => '#/components/schemas/RefreshInput',
                            ],
                        ],
                    ]),
                ),
            ),
        );
        $paths->addPath('/api/auth/refresh', $refreshPath);

        return $openApi;
    }
}
