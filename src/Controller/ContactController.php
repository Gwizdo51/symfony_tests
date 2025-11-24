<?php

namespace App\Controller;

use App\DTO\ContactDTO;
use App\Form\ContactType;
use Psr\Log\LoggerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Attribute\Route;

final class ContactController extends AbstractController {

    public function __construct(
        private MailerInterface $mailer,
        private LoggerInterface $logger,
    ) {}

    #[Route('/contact', name: 'contact')]
    public function index(Request $request): Response {
        $contactDTO = new ContactDTO();
        $form = $this->createForm(ContactType::class, $contactDTO);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // send the email
            $this->sendContactEmail($contactDTO);
            $this->addFlash('success', 'The message has been sent !');
            return $this->redirectToRoute('home');
        }
        return $this->render('contact/index.html.twig', [
            'contactForm' => $form,
        ]);
    }

    private function sendContactEmail(ContactDTO $contactDTO) {
        $this->logger->debug('ContactController - sendContactEmail called');
        $this->logger->debug("name: {$contactDTO->name}");
        $this->logger->debug("email: {$contactDTO->email}");
        $this->logger->debug("destination: {$contactDTO->destination}");
        $this->logger->debug("message: {$contactDTO->message}");
        $email = (new TemplatedEmail())
            ->from($contactDTO->email)
            // ->to('contact@localhost')
            ->to($contactDTO->destination)
            ->subject('Contact request')
            // ->text($contactDTO->message)
            ->htmlTemplate('emails/contact.html.twig')
            ->context([
                'contactDTO' => $contactDTO,
            ])
        ;
        $this->mailer->send($email);
    }
}
