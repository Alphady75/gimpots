<?php

namespace App\Controller\Admin;

use App\Entity\Questionnaire;
use App\Form\QuestionnaireType;
use Knp\Component\Pager\PaginatorInterface;
use App\Repository\QuestionnaireRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/questionnaires')]
class AdminQuestionnairesController extends AbstractController
{
    #[Route('/', name: 'admin_questionnaires_index', methods: ['GET'])]
    public function index(QuestionnaireRepository $questionnaireRepository, PaginatorInterface $paginator, Request $request): Response
    {
        $questionnaires = $paginator->paginate(
            $questionnaireRepository->findByDateDesc(),
            $request->query->getInt('page', 1),
            20
        );

        return $this->render('admin/admin_questionnaires/index.html.twig', [
            'questionnaires' => $questionnaires,
        ]);
    }

    #[Route('/{id}', name: 'admin_questionnaires_show', methods: ['GET'])]
    public function show(Questionnaire $questionnaire): Response
    {
        return $this->render('admin/admin_questionnaires/show.html.twig', [
            'questionnaire' => $questionnaire,
        ]);
    }

    #[Route('/{id}', name: 'admin_questionnaires_delete', methods: ['POST'])]
    public function delete(Request $request, Questionnaire $questionnaire, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$questionnaire->getId(), $request->request->get('_token'))) {
            $entityManager->remove($questionnaire);
            $entityManager->flush();
        }

        $this->addFlash('success', 'Questionnaire supprimé avec succès!');

        return $this->redirectToRoute('admin_questionnaires_index', [], Response::HTTP_SEE_OTHER);
    }
}
