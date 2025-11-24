<?php

namespace App\Controller\API;

use App\Entity\Company;
use App\Repository\CompanyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Requirement\Requirement;

#[Route('/api/company')]
class CompanyController extends AbstractController {

    public function __construct(
        private CompanyRepository $companyRepository,
    ) {}

    #[Route('/', methods: ['GET'])]
    public function index() {
        $companies = $this->companyRepository->findAll();
        return $this->json($companies, 200, [], [
            'groups' => ['recipes.index']
        ]);
    }

    #[Route('/{id}', methods: ['GET'], requirements: ['id' => Requirement::DIGITS])]
    public function show(Company $company) {
        return $this->json($company, 200, [], [
            'groups' => ['recipes.index', 'recipes.show']
        ]);
    }

}
