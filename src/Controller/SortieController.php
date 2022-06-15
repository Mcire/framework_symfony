<?php

namespace App\Controller;
use App\Entity\Sortie;
use App\Form\SortieType;
use App\Entity\Produit;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SortieController extends AbstractController
{
    #[Route('/Sortie/create', name: 'sortie_create')]
    public function index(ManagerRegistry $doctrine): Response
    {
        /*return $this->render('sortie/index.html.twig', [
            'controller_name' => 'SortieController',
        ]);*/
        $entityManager = $doctrine->getManager();

        $sortie = new Sortie();

        $form = $this->createForm(SortieType::class, $sortie, array('action' => $this->generateUrl('sortie_add')));
        $data['form'] = $form->createView();

        $data['sorties'] = $entityManager->getRepository(Sortie::class)->findAll();
        return $this->render('sortie/create.html.twig',$data);
    }
        //function add -> Ajout de produit
    #[Route('/Sortie/add', name: 'sortie_add')]
    public function add(ManagerRegistry $doctrine, Request $request): Response
    {
        $entityManager = $doctrine->getManager();
    
        $s = new Sortie();
        $form = $this->createForm(SortieType::class, $s);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) 
        {
            $s = $form->getData();
            // recuperation de l'id du User 
            //$s->setUser($this->getUser());
            $qsortie = $s->getQuantite();
            $p = $entityManager->getRepository(Produit::class)->find($s->getIdProduit()->getId());
            if($p->getStock() < $s->getQuantite())
            {
                $s = new Sortie();
                $form = $this->createForm(SortieType::class, $s, array('action' => $this->generateUrl('sortie_add')));
                $data['form'] = $form->createView();
                $data['sorties'] = $entityManager->getRepository(Sortie::class)->findAll();
                $data['error_message'] = 'Le stock disponible est inferieur à '.$qsortie;
                return $this->render('sortie/create.html.twig', $data);
            }
            else
            {
                $entityManager->persist($s);
                $entityManager->flush();
                // Mise a jour du produit 
                $Stock = $p->getStock() - $s->getQuantite();
                $p->setStock($Stock);
                $entityManager->flush();
    
                return $this->redirectToRoute('sortie_create');
                }
                
            }
    
        }
}
