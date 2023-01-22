<?php

namespace App\Controller;

use App\Entity\Event;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\EventRepository;

class EvenementsController extends AbstractController
{
    #[Route('/evenements', name: 'app_evenements')]
    public function events(EventRepository $eventRepository, PaginatorInterface $paginator, Request $request): Response
    {
        $events = $paginator->paginate(
            $eventRepository->findBy(['online' => 1]),
            $request->query->getInt('page', 1),
            9
        );

        return $this->render('evenements/events.html.twig', [
            'events' => $events,
        ]);
    }

    #[Route('/evenements/{slug}', name: 'event_details', methods: ['GET'])]
    public function details(Event $event): Response
    {
        return $this->render('evenements/details.html.twig', [
            'event' => $event,
        ]);
    }
}
