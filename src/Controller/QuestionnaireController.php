<?php

namespace App\Controller;

use App\Entity\Questionnaire;
use App\Form\QuestionnaireType;
use App\Form\RappelerType;
use App\Repository\QuestionnaireRepository;
use App\Form\SecurityCodeType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;

class QuestionnaireController extends AbstractController
{
    #[Route('/reduire-vos-impots', name: 'test_eligibilite', methods: ['GET', 'POST'])]
    public function testElibibilite(Request $request, EntityManagerInterface $entityManager, MailerInterface $mailerInterface): Response
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

            $this->addFlash('warning', 'Pour assurer la confidentialité un code sms vous a été envoyé par mail');

            return $this->redirectToRoute('verify_security_code', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('questionnaire/test_eligibilite.html.twig', [
            'form' =>   $form,
        ]);
    }

    #[Route('/code-de-verification', name: 'verify_security_code', methods: ['GET', 'POST'])]
    public function virifySecurityCode(Request $request, EntityManagerInterface $entityManager, 
        QuestionnaireRepository $questionnaireRepository): Response
    {
        $errors = null;

        $form = $this->createForm(SecurityCodeType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $query = $form->get('securityCode')->getData();

            $questionnaire = $questionnaireRepository->findOneBy(['securityCode' => $query]);

            if(!$questionnaire){
                $errors = "Le code de vérification \"". $query ."\" est invalide";
            }else{
                return $this->redirectToRoute('code_result', ['securitycode' => $query], Response::HTTP_SEE_OTHER);
            }
            
        }

        return $this->renderForm('questionnaire/verify_security_code.html.twig', [
            'form' =>   $form,
            'errors' => $errors,
        ]);
    }


    #[Route('/resultat/code-securite={securitycode}', name: 'code_result', methods: ['GET', 'POST'])]
    public function virifyResult($securitycode, QuestionnaireRepository $questionnaireRepository, Request $request,
     MailerInterface $mailerInterface): Response
    {
        $questionnaire = $questionnaireRepository->findOneBy(['securityCode' => $securitycode]);

        if (!$questionnaire) {
            return $this->redirectToRoute('verify_security_code', [], Response::HTTP_SEE_OTHER);
        }

        $form = $this->createForm(RappelerType::class, $questionnaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // Envoie de mail
            $email = (new TemplatedEmail())
                ->from('impots@gmail.com')
                ->to($questionnaire->getEmail())
                ->subject('Votre code de sécurité')
                ->htmlTemplate('emails/rappeler_email.html.twig')
                ->context([
                    'nom' => $questionnaire->getNom(),
                    'useremail'  =>  $questionnaire->getEmail(),
                    'questionnaire' => $questionnaire,
                ])
            ;

            $mailerInterface->send($email);

            $this->addFlash('success', 'Un mail de rappel vient d\'être envoyer à l\'administrateur');

            return $this->redirectToRoute('rappel_message_sended', ['securitycode' => $securitycode], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('questionnaire/show.html.twig', [
            'questionnaire' => $questionnaire,
            'form' => $form,
        ]);
    }


    #[Route('/resultat/code-securite={securitycode}/message-envoyer', name: 'rappel_message_sended', methods: ['GET', 'POST'])]
    public function virifyMessageSended($securitycode, QuestionnaireRepository $questionnaireRepository, Request $request,): Response
    {
        $questionnaire = $questionnaireRepository->findOneBy(['securityCode' => $securitycode]);

        if (!$questionnaire) {
            return $this->redirectToRoute('verify_security_code', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('questionnaire/message_rappel_envoyer.html.twig', [
            'questionnaire' => $questionnaire,
        ]);
    }
}
