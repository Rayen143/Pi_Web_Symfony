<?php

namespace App\Controller;

use App\Repository\ProdRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ChartController extends AbstractController
{
    #[Route('/chart', name: 'app_chart')]
    public function index(): Response
    {
        return $this->render('chart/index.html.twig', [
            'controller_name' => 'ChartController',
        ]);
    }
    
    #[Route('/piechart', name: 'chart')]
    public function chart(ProdRepository $prodRepository): Response
    {
        // Retrieve the data needed for the pie chart
        $categoryCounts = $prodRepository->getCategoryCounts();

        // Prepare the data for the chart
        $chartData = [];
        foreach ($categoryCounts as $category => $count) {
            $chartData['labels'][] = $category;
            $chartData['data'][] = $count;
        }

        // Render the pie chart template with the chart data
        return $this->render('prod/pie_chart.html.twig', [
            'chartData' => $chartData,
        ]);
    }
}
