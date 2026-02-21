<?php declare(strict_types=1);

namespace App\State\Badge;

use ApiPlatform\Metadata\CollectionOperationInterface;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\ApiResource\Badge\BadgeSystem;
use App\Enum\Badge\BadgeSystemsEnum;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

final class BadgeSystemProvider extends AbstractBadgeStateHandler implements ProviderInterface {
    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null {
        $badgeSystemsArray = array_map(
            fn (BadgeSystemsEnum $case): BadgeSystem => new BadgeSystem(strtolower($case->name)),
            BadgeSystemsEnum::cases(),
        );
        if ($operation instanceof CollectionOperationInterface) {
            return $badgeSystemsArray;
        }
        $this->logger->debug('Uri variables :', $uriVariables);
        foreach ($badgeSystemsArray as $badgeSystem) {
            if ($badgeSystem->name === $uriVariables['system']) {
                return $badgeSystem;
            }
        }
        throw new NotFoundHttpException('Not found');
    }
}
