<?php

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RegistrationController extends AbstractController
{
    #[Route('/reg', name: 'reg')]
    public function reg(): Response
    {

        $regform = $this->createFormBuilder()
            ->add('username')
            ->add('password')

            ->add('register', SubmitType::class)
            ->getForm()
        ;

        return $this->render('registration/index.html.twig', [
            'regform' => $regform->createView()
        ]);
    }
}
