<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Form\CategorieType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategorieController extends AbstractController
{
    #[Route('/Categorie/create', name: 'categorie_create')]
    public function index(ManagerRegistry $doctrine,Request $request): Response
    {
        $entityManager = $doctrine->getManager();

        $cat = new Categorie();

        $form = $this->createForm(CategorieType::class, $cat, array('action' => $this->generateUrl('categorie_add')));
        $data['form'] = $form->createView();

        $data['categories'] = $entityManager->getRepository(Categorie::class)->findAll();
        return $this->render('categorie/create.html.twig',$data);
    }
    #[Route('/Categorie/add', name: 'categorie_add')]
    public function add(ManagerRegistry $doctrine,Request $request): Response
    {
        $cat = new Categorie();
        $form = $this->createForm(CategorieType::class, $cat);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) 
        {
            $cat = $form->getData();
            //$prod->setUser($this->getUser());
            $entityManager = $doctrine->getManager();
            $entityManager->persist($cat);
            $entityManager->flush();
        }
        return $this->redirectToRoute('categorie_create');
    }
}
