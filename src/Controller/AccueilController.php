<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccueilController extends AbstractController
{
    #[Route('/accueil', name: 'app_accueil')]
    public function index(): Response
    {
        return $this->render('accueil/index.html.twig', [
            'controller_name' => 'Vous etes le bienvenue!!!',
        ]);
    }
}



/*
->add('idCategorie',TextType::class , array(['label' => 'Categorie du produit'],'attr'=>array('class'=>'form-control form-group')))
->add('idUser',TextType::class , array(['label' => 'Enregistreur'],'attr'=>array('class'=>'form-control form-group')))
->add('valider',SubmitType::class, array('attr'=>array('class'=>'btn btn-success form-group')))
;*/