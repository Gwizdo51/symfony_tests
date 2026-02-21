<?php declare(strict_types=1);

namespace App\State\Badge;

use ApiPlatform\Metadata\CollectionOperationInterface;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

final class CompanyProvider extends AbstractBadgeStateHandler implements ProviderInterface {
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
