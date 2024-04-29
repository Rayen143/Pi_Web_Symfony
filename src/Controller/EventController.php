<?php


namespace App\Controller;

use App\Entity\Event;
use App\Form\Event1Type;
use App\Repository\EventRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelHigh;
use Endroid\QrCode\Label\Label;
use Endroid\QrCode\RoundBlockSizeMode\RoundBlockSizeModeMargin;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\QrCode;



#[Route('/event')]
class EventController extends AbstractController
{
  #[Route('/', name: 'app_event_index', methods: ['GET'])]
  public function index(Request $request, EventRepository $eventRepository, EntityManagerInterface $entityManager): Response
  {
    $searchTerm = $request->query->get('search');

    $events = $eventRepository->findAll();

    if ($searchTerm) {
      $qb = $entityManager->createQueryBuilder(); // Use injected EntityManager

      $qb->select('e')
        ->from(Event::class, 'e');

      $qb->where('e.title LIKE :searchTerm OR e.description LIKE :searchTerm');
      $qb->setParameter('searchTerm', '%' . $searchTerm . '%');

      $events = $qb->getQuery()->getResult();
    }

    return $this->render('event/index.html.twig', [
      'events' => $events,
      'searchTerm' => $searchTerm,
    ]);
  }
    #[Route('/new', name: 'app_event_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $event = new Event();
        $form = $this->createForm(Event1Type::class, $event);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($event);
            $entityManager->flush();

            return $this->redirectToRoute('app_event_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('event/new.html.twig', [
            'event' => $event,
            'form' => $form,
        ]);
    }

    #[Route('/{eventId}', name: 'app_event_show', methods: ['GET'])]
    public function show(Event $event): Response
    {
        return $this->render('event/show.html.twig', [
            'event' => $event,
        ]);
    }

    #[Route('/{eventId}/edit', name: 'app_event_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Event $event, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(Event1Type::class, $event);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_event_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('event/edit.html.twig', [
            'event' => $event,
            'form' => $form,
        ]);
    }

    #[Route('/{eventId}', name: 'app_event_delete', methods: ['POST'])]
    public function delete(Request $request, Event $event, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$event->getEventId(), $request->request->get('_token'))) {
            $entityManager->remove($event);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_event_index', [], Response::HTTP_SEE_OTHER);
    }

   
    #[Route('/{eventId}/qr-code', name: 'app_event_qr_code', methods: ['GET'])]
    public function generateQRCode(Event $event): Response
    {
        // Générer le contenu du QR Code en utilisant les informations de l'événement
        $qrContent = sprintf(
            "Event: %s\nDate: %s\nLocation: %s",
            $event->getTitle(),
            $event->getStartdate()->format('Y-m-d'),
            $event->getLocationId()
        );

        // Créer un objet QR Code avec le contenu
        $qrCode = new QrCode($qrContent);

        // Générer l'image du QR Code
        $qrCode->setSize(200); // Définir la taille du QR Code
        $qrCode->setMargin(10); // Définir la marge

        // Créer une réponse avec le contenu de l'image du QR Code
        $response = new Response($qrCode->getSize(), Response::HTTP_OK, ['Content-Type' => 'image/png']);
        return $response;
    }

}

