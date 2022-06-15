<?php

namespace App\Controller;

use App\Entity\Role;
use App\Form\RoleType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RoleController extends AbstractController
{
    #[Route('/Role/create', name: 'role_create')]
    public function index(ManagerRegistry $doctrine,Request $request): Response
    {
        $entityManager = $doctrine->getManager();
        $roles = new Role();

        $form = $this->createForm(RoleType::class, $roles, array('action' => $this->generateUrl('role_add')));
        $data['form'] = $form->createView();

        $data['roles'] = $entityManager->getRepository(Role::class)->findAll();
        return $this->render('role/create.html.twig',$data);
    }

    #[Route('/Role/add', name: 'role_add')]
    public function add(ManagerRegistry $doctrine,Request $request): Response
    {
        $roles = new Role();
        $form = $this->createForm(RoleType::class, $roles);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) 
        {
            $roles = $form->getData();
            //$prod->setUser($this->getUser());
            $entityManager = $doctrine->getManager();
            $entityManager->persist($roles);
            $entityManager->flush();
        }
        return $this->redirectToRoute('role_create');
    }
}
