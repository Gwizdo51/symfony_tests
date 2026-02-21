<?php declare(strict_types=1);

namespace App\State\Badge;

use App\Enum\Badge\BadgeSystemsEnum;
use App\Service\Badge\BadgeServiceInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;
use ValueError;

abstract class AbstractBadgeStateHandler {
    public function __construct(
        protected readonly LoggerInterface $logger,
    ) {}

    protected function getService($systemName): BadgeServiceInterface {
        $this->logger->debug("\$systemName : {$systemName}");
        try {
            $badgeSystemServiceClassName = BadgeSystemsEnum::valueFromName(strtoupper($systemName));
        }
        catch (ValueError $e) {
            throw new UnprocessableEntityHttpException('The requested badge system is not available', $e);
        }
        return new $badgeSystemServiceClassName();
    }
}
