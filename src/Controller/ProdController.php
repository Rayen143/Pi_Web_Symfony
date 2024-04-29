<?php

namespace App\Controller;
use Knp\Component\Pager\PaginatorInterface;
use App\Entity\Prod;
use App\Entity\User;
use App\Entity\Categorie;

use App\Form\UpdateProdType;
use App\Entity\Panier;
use App\Form\ProductsFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request as HttpFoundationRequest;
use App\Repository\CategorieRepository; 
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class ProdController extends AbstractController
{
    #[Route('/prod', name: 'app_prod')]
    public function index(): Response
    {
        return $this->render('prod/index.html.twig', [
            'controller_name' => 'ProdController',
        ]);
    }

    #[Route('/export-csv', name: 'export_csv')]
    public function exportCsv(): Response
    {
        // Récupérer les produits depuis la base de données
        $products = $this->getDoctrine()->getRepository(Prod::class)->findAll();

        // Construire la chaîne CSV avec des en-têtes de colonne
        $csvContent = "Code Produit,Description,Unité,Catégorie,Image,Quantité Minimum,Quantité en Stock,Prix Unitaire\n";
        foreach ($products as $prod) {
            $csvContent .= sprintf(
                '"%s","%s","%s","%s","%s","%s","%s","%s"',
                $prod->getCodeproduit(),
                $prod->getDes(),
                $prod->getIdunite(),
                $prod->getCat(), // Supposons que getLibcategorie() renvoie le libellé de la catégorie
                $prod->getImage(),
                $prod->getQtemin(),
                $prod->getQtestock(),
                $prod->getPrixunitaire()
            ) . "\n";
        }

        // Nom du fichier CSV
        $fileName = 'products.csv';

        // Créer une réponse avec le contenu CSV
        $response = new Response($csvContent);

        // Définir les en-têtes de la réponse pour le téléchargement du fichier
        $response->headers->set('Content-Type', 'text/csv');
        $response->headers->set('Content-Disposition', 'attachment; filename="' . $fileName . '"');

        return $response;
    }
    #[Route('/prod/ajouter', name: 'app_prod_ajouter')]
    public function ajouterProduit(Request $request): Response
{
    $produit = new Prod();
    $form = $this->createForm(ProductsFormType::class, $produit);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        // Handle image upload
        $imageFile = $form->get('image')->getData();

        if ($imageFile) {
            $newFilename = uniqid().'.'.$imageFile->guessExtension();

            try {
                $imageFile->move(
                    $this->getParameter('images_directory'),
                    $newFilename
                );
            } catch (FileException $e) {
                $this->addFlash('error', 'An error occurred while uploading the image.');
                return $this->redirectToRoute('app_prod_ajouter');
            }

            $produit->setImage($newFilename);
        }

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($produit);
        $entityManager->flush();

        return $this->redirectToRoute('app_prod');
    }

    return $this->render('prod/add.html.twig', [
        'form' => $form->createView(),
    ]);
}
    #[Route('/prod/afficher', name: 'app_prod')]
    public function afficher(): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $produits = $entityManager->getRepository(Prod::class)->findAll();

        return $this->render('prod/liste.html.twig', [
            'produits' => $produits,
        ]);
    }


    #[Route('/prod/delete/{idProduit}', name: 'product_delete')]
    public function deleteProduit(int $idProduit, ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();
    
        // Obtenir une instance de l'EntityManager
        /** @var EntityManagerInterface $entityManager */
        $entityManager = $doctrine->getManager();
        
        // Créer une query builder pour la suppression
        $qb = $entityManager->createQueryBuilder();
        $qb->delete('App\Entity\Prod', 'c')
            ->where('c.idProduit = :idProduit')
            ->setParameter('idProduit', $idProduit);
    
        // Exécuter la suppression
        $deleted = $qb->getQuery()->execute();
    
        if ($deleted === 0) {
            // Gérer le cas où aucune ligne n'a été supprimée
            throw $this->createNotFoundException('produit not found');
        }
    
        // Rediriger vers la page de liste des paniers
        return $this->redirectToRoute('app_prod');
    }
    #[Route('/prod/edit/{idProduit}', name: 'product_edit')]
public function editProduit(Request $request, int $idProduit, CategorieRepository $categorieRepository, EntityManagerInterface $entityManager): Response
{
    
    // Find the product entity from the database
    $produit = $entityManager->getRepository(Prod::class)->find($idProduit);

    // Check if the product exists
    if (!$produit) {
        throw $this->createNotFoundException('Product not found');
    }

    // Fetch all categories
    $categories = $categorieRepository->findAll();

    // Create the form
    $form = $this->createForm(UpdateProdType::class, $produit, ['categories' => $categories]);
    $form->handleRequest($request);

    // Handle form submission
    if ($form->isSubmitted() && $form->isValid()) {
        // Persist changes to the database
        $entityManager->flush();

        // Add flash message
        $this->addFlash('success', 'Product updated successfully.');

        // Redirect to the product list page
        return $this->redirectToRoute('app_prod');
    }

    // Render the edit form
    return $this->render('prod/edit.html.twig', [
        'form' => $form->createView(),
    ]);
}

    
    #[Route('/products', name: 'product_list')]
    public function productList(Request $request, PaginatorInterface $paginator): Response
    {
        
        $query = $request->query->get('q');
        $entityManager = $this->getDoctrine()->getManager();
        $rep = $entityManager->getRepository(Prod::class);
    
        // Récupérer les produits filtrés par nom (si un terme de recherche est fourni)
        if ($query) {
            $products = $rep->findBy(['codeproduit' => $query]);
        } else {
            $products = $rep->findAll();
        }

        $products = $paginator->paginate(
            $products, /* query NOT result */
            $request->query->getInt('page', 1),
            6
        );
    
        // Get the images directory parameter
        $imagesDirectory = $this->getParameter('images_directory');
    
        // Render the product list view
        return $this->render('prod/listProduct.html.twig', [
            'products' => $products,
            'images_directory' => $imagesDirectory,
        ]);
    }
    

    #[Route('/product/{idProduit}', name: 'product_details')]
public function productDetails($idProduit, Request $request, EntityManagerInterface $entityManager): Response
{
    $product = $this->getDoctrine()->getRepository(Prod::class)->find($idProduit);

    if (!$product) {
        throw $this->createNotFoundException('Product not found');
    }

    // Handle adding the product to the cart
    if ($request->isMethod('POST')) {
        // Get the last user from the user table
        $lastUserId = $entityManager->createQueryBuilder()
            ->select('MAX(u.id)')
            ->from(User::class, 'u')
            ->getQuery()
            ->getSingleScalarResult();
        
        // Get the User object corresponding to the last user ID
        $lastUser = $this->getDoctrine()->getRepository(User::class)->find($lastUserId);

        // Create a new Panier entity and set its properties
        $panier = new Panier();
        $panier->setIdProduit($product);
        $panier->setIdUser($lastUser);
        $panier->setQuantite(0); // Set the initial quantity to 0

        // Persist and flush the Panier entity
        $entityManager->persist($panier);
        $entityManager->flush();

        // Redirect to the product details page
        return $this->redirectToRoute('product_details', ['idProduit' => $idProduit]);
    }

    return $this->render('prod/details.html.twig', [
        'product' => $product,
    ]);
}
#[Route('/prod/statistic', name: 'product_statistic')]
public function productStatistic(): Response
{
    $entityManager = $this->getDoctrine()->getManager();
    $products = $entityManager->getRepository(Prod::class)->findAll();

    $productCategoryCounts = [];
    foreach ($products as $product) {
        $categories = $product->getCategories();
        $categoryCount = count($categories);
        $productCategoryCounts[$product->getIdProduit()] = $categoryCount;
    }

    // Sort the products based on the category count in descending order
    arsort($productCategoryCounts);

    // Debugging
    dump($productCategoryCounts);
    dump($products);

    return $this->render('prod/statistic.html.twig', [
        'productCategoryCounts' => $productCategoryCounts,
        'produits' => $products,
    ]);
}

}
