<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Entity\User;
use App\Form\ProduitType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Request;

class ProduitController extends AbstractController
{
    //#[Route('/produit', name: 'app_produit')]
    #[Route('/Produit/create', name: 'produit_create')]
    public function index(ManagerRegistry $doctrine): Response
    {
        /*return $this->render('produit/index.html.twig', [
            'controller_name' => 'ProduitController',
        ]);*/
       // $entityManager =$doctrine->getManager();
        $entityManager = $doctrine->getManager();

        $prod = new Produit();
        $form = $this->createForm(ProduitType::class, $prod,array('action' => $this->generateUrl('produit_add')));
        
        $data['form'] = $form->createView();

        $data['produits'] = $entityManager->getRepository(Produit::class)->findAll();
        return $this->render('produit/create.html.twig',$data);
    }

    #[Route('/Produit/add', name: 'produit_add')]
    public function add(ManagerRegistry $doctrine,Request $request): Response
    {
        $prod = new Produit();
        $form = $this->createForm(ProduitType::class, $prod);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) 
        {
            $prod = $form->getData();
            $prod->setIdUser($this->getUser());
            $entityManager = $doctrine->getManager();
            $entityManager->persist($prod);
            $entityManager->flush();
        }
        return $this->redirectToRoute('produit_create');
    }
}
