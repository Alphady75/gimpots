<?php

namespace App\Controller;

use App\Entity\Questionnaire;
use App\Form\QuestionnaireType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function home(Request $request, EntityManagerInterface $entityManager, MailerInterface $mailerInterface): Response
    {
        $questionnaire = new Questionnaire();
        $form = $this->createForm(QuestionnaireType::class, $questionnaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $code = random_int(100000000, 999999999);

            $questionnaire->setSecurityCode($code);

            $entityManager->persist($questionnaire);
            $entityManager->flush();


            // Envoie de mail
            $email = (new TemplatedEmail())
                ->from('impots@gmail.com')
                ->to($questionnaire->getEmail())
                ->subject('Votre code de sécurité')
                ->htmlTemplate('emails/verify_security_code_email.html.twig')
                ->context([
                    'useremail'  =>  $questionnaire->getEmail(),
                    'securityCode'   =>  $code
                ])
            ;

            $mailerInterface->send($email);

            $this->addFlash('warning', 'Pour assurer la confidentialité un code sms va vous être envoyé par mail');

            return $this->redirectToRoute('verify_security_code', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('home/index.html.twig', [
            'form' => $form,
        ]);
    }
}
