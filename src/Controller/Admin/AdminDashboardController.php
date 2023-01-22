<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\PostRepository;
use App\Repository\EventRepository;
use App\Repository\UserRepository;
use App\Repository\QuestionnaireRepository;

class AdminDashboardController extends AbstractController
{
    #[Route('/admin/dashboard', name: 'admin_dashboard')]
    public function dashboard(PostRepository $postRepository, EventRepository $eventRepository, UserRepository $userRepository,
        QuestionnaireRepository $questionnaireRepository): Response
    {
        $activites = $questionnaireRepository->countByActivite();

        $activiteFields = [];
        $activiteCount = [];

        // Démontage des données
        foreach($activites as $activite){

            $activiteFields[] = $activite['activiteFields'];
            $activiteCount[] = $activite['groupActivite'];

        }

        $logements = $questionnaireRepository->countByLogement();

        $logementFields = [];
        $logementCount = [];

        // Démontage des données
        foreach($logements as $logement){

            $logementFields[] = $logement['logementFields'];
            $logementCount[] = $logement['groupLogement'];

        }


        $sitMatrimoniales = $questionnaireRepository->countBySitMatrimoniale();

        $sitMatrimonialeFields = [];
        $sitMatrimonialeCount = [];

        // Démontage des données
        foreach($sitMatrimoniales as $sitMatrimoniale){

            $sitMatrimonialeFields[] = $sitMatrimoniale['sitMatrimonialeFields'];
            $sitMatrimonialeCount[] = $sitMatrimoniale['groupSitMatrimoniale'];

        }

        return $this->render('admin/admin_dashboard/dashboard.html.twig', [

            'activiteFields'  =>  json_encode($activiteFields),
            'groupActivite'  =>  json_encode($activiteCount),

            'logementFields'  =>  json_encode($logementFields),
            'groupLogement'  =>  json_encode($logementCount),

            'sitMatrimonialeFields'  =>  json_encode($sitMatrimonialeFields),
            'groupSitMatrimoniale'  =>  json_encode($sitMatrimonialeCount),

            'posts' => $postRepository->findAll(),
            'events' => $eventRepository->findAll(),
            'users' => $userRepository->findAll(),
            'questionnaires' => $questionnaireRepository->findAll(),
        ]);
    }
}
