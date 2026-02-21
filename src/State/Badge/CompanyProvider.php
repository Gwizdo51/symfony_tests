<?php

namespace App\State\Badge;

use ApiPlatform\Metadata\CollectionOperationInterface;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Enum\Badge\BadgeSystemsEnum;
use App\Service\Badge\BadgeServiceInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;
use ValueError;

class CompanyProvider implements ProviderInterface {

    public function __construct(
        private readonly LoggerInterface $logger,
    ) {}

    private function getService($systemName): BadgeServiceInterface {
        $this->logger->debug("\$systemName : {$systemName}");
        try {
            $badgeSystemServiceClassName = BadgeSystemsEnum::valueFromName(strtoupper($systemName));
        }
        catch (ValueError $e) {
            throw new UnprocessableEntityHttpException('The requested badge system is not available', $e);
        }
        return new $badgeSystemServiceClassName();
    }

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null {
        $service = $this->getService($uriVariables['system']);
        $companies = $service->getCompanies();
        if ($operation instanceof CollectionOperationInterface) {
            return $companies;
        }
        $requestedCompanyId = (int) $uriVariables['id'];
        $this->logger->debug("\$requestedCompanyId : {$requestedCompanyId}");
        foreach ($companies as $company) {
            if ($company->id === $requestedCompanyId) {
                return $company;
            }
        }
        throw new NotFoundHttpException('Not found');
    }
}
