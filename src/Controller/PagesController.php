<?php

namespace App\Controller;

use App\Form\MessageType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;

class PagesController extends AbstractController
{

    #[Route('/apropos', name: 'pages_apropos')]
    public function apropos(): Response
    {
        return $this->render('pages/apropos.html.twig', [
            
        ]);
    }

    #[Route('/contact', name: 'pages_contact')]
    public function contact(Request $request, MailerInterface $mailerInterface): Response
    {
        $form = $this->createForm(MessageType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            // Envoie de mail
            $email = (new TemplatedEmail())
                ->from($form->get('email')->getData())
                ->to('impots@domain.com')
                ->subject('Contact depuis le site (Nom du mon site)')
                ->htmlTemplate('emails/_message.html.twig')
                ->context([
                    'useremail'  =>  $form->get('email')->getData(),
                    'sujet' =>  $form->get('sujet')->getData(),
                    'content'   =>  $form->get('content')->getData()
                ])
            ;

            $mailerInterface->send($email);

            $this->addFlash('success', 'Mail de contact envoyer nous vous recontacterons dans peut de temps');
            return $this->redirectToRoute('pages_contact');
        }

        return $this->renderForm('pages/contact.html.twig', [
            'form' => $form,
        ]);
    }
}
