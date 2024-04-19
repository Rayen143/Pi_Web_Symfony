<?php

namespace App\Controller;
use Twilio\Rest\Client;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminStatsUserStatutController extends AbstractController
{
    #[Route('/admin/stats/user/statut', name: 'app_admin_stats_user_statut')]
    public function stats(UserRepository $userRepository): Response
    {
        // Récupérer le nombre total d'utilisateurs
        $totalUsers = $userRepository->countAllUsers();

        

        // Passer les données au template pour affichage
        return $this->render('admin_stats_user_statut/stats.html.twig', [
            'totalUsers' => $totalUsers,
            
        ]);
    }
}
