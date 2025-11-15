<?php

namespace App\Controller;

use App\Entity\Company;
use App\Form\CompanyType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class CompanyController extends AbstractController {
    // #[Route('/company', name: 'app_company')]
    // public function index(): Response {
    //     return $this->render('company/index.html.twig', [
    //         'controller_name' => 'CompanyController',
    //     ]);
    // }

    #[Route('/company/create', name: 'company.create')]
    public function create(Request $request, EntityManagerInterface $em) {
        $newCompany = new Company();
        $form = $this->createForm(CompanyType::class, $newCompany);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($newCompany);
            $em->flush();
            $this->addFlash('success', "The company {$newCompany->getName()} has been created");
            return $this->redirectToRoute('home');
        }
        return $this->render('company/create.html.twig', [
            'companyForm' => $form,
        ]);
    }

    #[Route('/company/{id}/edit', name: 'company.edit', methods: ['GET', 'POST'])]
    public function edit(Company $company, Request $request, EntityManagerInterface $em) {
        // dd($company);
        $form = $this->createForm(CompanyType::class, $company);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // dd($company);
            $em->flush();
            $this->addFlash('success', "The company {$company->getName()} has been updated");
            return $this->redirectToRoute('home');
        }
        return $this->render('company/edit.html.twig', [
            'company' => $company,
            'companyForm' => $form,
        ]);
    }

    #[Route('/company/{id}/delete', name: 'company.delete', methods: ['DELETE'])]
    public function delete(Company $company, EntityManagerInterface $em) {
        $em->remove($company);
        $em->flush();
        $this->addFlash('success', "The company {$company->getName()} has been deleted");
        return $this->redirectToRoute('home');
    }
}
