<?php

namespace App\Controller;

use App\Repository\ClientRepository;
use App\Repository\CompanyRepository;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

// final class HomeController extends AbstractController
// {
//     #[Route('/home', name: 'app_home')]
//     public function index(): Response
//     {
//         return $this->render('home/index.html.twig', [
//             'controller_name' => 'HomeController',
//         ]);
//     }
// }

final class HomeController extends AbstractController {

    // private static int $myNumber = 18;

    #[Route('/', name: 'home')]
    public function index(Request $request, ClientRepository $clientRepository, CompanyRepository $companyRepository): Response {
        // dd($request);
        // $temp = self::$myNumber;
        // return new Response("Yo, myNumber = {$temp}");
        $name = $request->query->get('name', 'Guest');
        $clients = $clientRepository->findAll();
        $companies = $companyRepository->findByMinNumberOfMembers(0);
        // dd($companies);
        return $this->render('home/index.html.twig', [
            // 'data' => 'Some useful data',
            'person' => [
                'firstName' => 'John',
                'lastName' => 'Doe',
            ],
            'htmlValue' => '<strong>Hello in strong</strong>',
            'userName' => $name,
            'clients' => $clients,
            'companies' => $companies,
        ]);
    }

    #[Route('/{id}', name: 'home.testId', requirements: ['id' => '\d+'])]
    // public function testId(Request $request, int $id): Response {
    //     // dd($request->attributes);
    //     dd($id);
    // }
    public function testId(Request $request, int $id): JsonResponse {
        return $this->json([
            'id' => $id,
        ]);
    }

    #[Route('/welcome', name: 'home.welcome')]
    public function welcome(Request $request): Response {
        return $this->render('home/welcome.html.twig');
    }
}
