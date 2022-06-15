<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Form\UserType;
use App\Security\LoginAuthenticator;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry as PersistenceManagerRegistry;
use Symfony\Bridge\Doctrine\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

class RegistrationController extends AbstractController
{
     #[Route('/Registration/register', name: 'register_create')]
    //#[Route('/User/user', name: 'user_create')]
    public function index(PersistenceManagerRegistry $doctrine,Request $request): Response
    {
        $entityManager = $doctrine->getManager();
        $user = new User();
        $form = $this->createForm(UserType::class, $user,array('action' => $this->generateUrl('register_register')));
        
        $data['form'] = $form->createView();

        $data['users'] = $entityManager->getRepository(User::class)->findAll();
        return $this->render('registration/create.html.twig',$data);
    }
    #[Route('/Registration/add', name: 'register_register')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, UserAuthenticatorInterface $userAuthenticator, LoginAuthenticator $authenticator, EntityManagerInterface $entityManager): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
            $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            $entityManager->persist($user);
            $entityManager->flush();
            // do anything else you need here, like send an email

            return $userAuthenticator->authenticateUser(
                $user,
                $authenticator,
                $request
            );
        }
        return $this->redirectToRoute('register_create');
        /*return $this->render('user/create.html.twig', [
            'registrationForm' => $form->createView(),
        ]);*/
        // return $this->render('registration/create.html.twig', [
        //     'registrationForm' => $form->createView(),
        // ]);
    }
}
