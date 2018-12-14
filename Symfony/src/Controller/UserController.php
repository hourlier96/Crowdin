<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Entity\User;
use App\Form\FormType;

class UserController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function home()
    {
        return $this->render('base.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }

     /**
     * @Route("/show/", name="show_usrs")
     */
    public function show_users()
    {
        $repo = $this->getDoctrine()->getRepository(User::class);
        $users = $repo->findAll();
        return $this->render('user/show_users.html.twig', [
            'users' => $users
        ]);
    }

    /**
     * @Route("/create_user", name="create")
     */
    public function create_user(Request $request, ObjectManager $manager, 
                                UserPasswordEncoderInterface $encoder) {
        $user = new User();
        $form = $this->createFormBuilder($user)
                     ->add('username')
                     ->add('password', PasswordType::class)
                     ->add('confirm_password', PasswordType::class)
                     ->add('email', EmailType::class)
                     ->add('submit', SubmitType::class)
                     ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $hash = $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($hash);
            $manager->persist($user);
            $manager->flush();
            return $this->redirectToRoute('login_user');
        }
        return $this->render('user/create_user.html.twig', [
            'form_user' => $form->createView()
        ]);
    }

    /**
     * @Route("/login", name="login_user")
     */
    public function login_user() {
        return $this->render('user/login_user.html.twig');
    }

    /**
     * @Route("/logout", name="logout_user")
     */
    public function logout_user() {}

    /**
     * @Route("/account/{id}", name="account_user")
     */
    public function account_user($id, Request $request, ObjectManager $manager) {
        $repo = $this->getDoctrine()->getRepository(User::class);
        $user = $repo->find($id);

        $form = $this->createForm(FormType::class, $user);

        if ($form->isSubmitted() && $form->isValid()) {
            $form->handleRequest($request);
            $manager->flush();
        }

        return $this->render('user/account.html.twig', [
            'user' => $user,
            'form_wall' => $form->createView()
        ]);
    }


    /**
     * @Route("/change_pwd/{id}", name="change_password")
     */
    public function change_password($id, Request $request, ObjectManager $manager,
                                    UserPasswordEncoderInterface $encoder) {                 
        
        $repo = $this->getDoctrine()->getRepository(User::class);  //Simplifiable, cf 1h07 vidéo 1/4
        $user = $repo->find($id);

        $form = $this->createFormBuilder($user)
                     ->add('password', PasswordType::class)
                     ->add('submit', SubmitType::class)
                     ->getForm();
                     
        if ($form->isSubmitted() && $form->isValid()) {
            $form->handleRequest($request);
            $hash = $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($hash);
            $manager->flush();
        }
        return $this->render('user/change_password.html.twig', [
            'user' => $user,
            'form_pwd' => $form->createView()
        ]);
    }
}
