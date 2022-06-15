<?php

namespace App\Controller;

use App\Entity\Entree;
use App\Form\EntreeType;
use App\Entity\Produit;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EntreeController extends AbstractController
{
   // #[Route('/entree', name: 'app_entree')]
    #[Route('/Entree/create', name: 'entree_create')]
    public function index(ManagerRegistry $doctrine): Response
    {
        /*return $this->render('entree/index.html.twig', [
            'controller_name' => 'EntreeController',
        ]);*/
        
        $entityManager = $doctrine->getManager();

        $prod = new Entree();

        $form = $this->createForm(EntreeType::class, $prod, array('action' => $this->generateUrl('entree_add')));
        $data['form'] = $form->createView();

        $data['entrees'] = $entityManager->getRepository(Entree::class)->findAll();
        return $this->render('entree/create.html.twig',$data);
    }
    #[Route('/Entree/add', name: 'entree_add')]
    public function add(ManagerRegistry $doctrine, Request $request): Response
    {
        $entityManager = $doctrine->getManager();

        $e = new Entree();
        $prod = new Produit();
        $form = $this->createForm(EntreeType::class, $e);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $e = $form->getData();
            // recuperation de l'id du User 
           // $e->setUser($this->getUser());

            $entityManager->persist($e);
            $entityManager->flush();
            // Mise a jour du produit 
            $prod = $entityManager->getRepository(Produit::class)->find($e->getIdProduit()->getId());
            $Stock = $prod->getStock() + $e->getQuantite();
            $prod->setStock($Stock);
            $entityManager->flush();
        }
        return $this->redirectToRoute('entree_create');
    }
}
