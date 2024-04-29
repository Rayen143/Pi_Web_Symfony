<?php

namespace App\Service;

use App\Entity\Prod;
use Doctrine\ORM\EntityManagerInterface;
use League\Csv\Writer;

class CsvExporter
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function exportProduitsToCsv(string $filePath): void
    {
        $produits = $this->entityManager->getRepository(Prod::class)->findAll();

        $csv = Writer::createFromPath($filePath, 'w+');
        $csv->insertOne(['ID', 'Code Produit', 'Description', 'Unité', 'Catégorie', 'Quantité Minimum', 'Quantité en Stock', 'Prix Unitaire']);

        foreach ($produits as $produit) {
            $csv->insertOne([
                $produit->getIdProduit(),
                $produit->getCodeProduit(),
                $produit->getDes(),
                $produit->getIdUnite(),
                $produit->getCat(),
                $produit->getQteMin(),
                $produit->getQteStock(),
                $produit->getPrixUnitaire(),
            ]);
        }

        $csv->output($filePath);
    }
}
