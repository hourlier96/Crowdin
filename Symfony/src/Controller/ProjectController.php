<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Entity\Project;
use App\Entity\User;

class ProjectController extends AbstractController
{
    /**
     * @Route("/new/{id}", name="project_create")
     */
    public function createProject($id, Request $request, ObjectManager $manager){
        $project = new Project();
        $form = $this->createFormBuilder($project)
            ->add('name', TextType::class)
            ->add('Language',TextType::class)
            ->add('save', SubmitType::class, ['label' => 'Create Project'])
            ->getForm();
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $repo = $this->getDoctrine()->getRepository(User::class);  //Simplifiable, cf 1h07 vidéo 1/4
            $user = $repo->find($id);
            $project->setUser($user);
            $user->setNbProjects($user->getNbProjects() + 1);
            $manager->persist($project);
            $manager->flush();
        }
        return $this->render('user/form_project.html.twig', [
            'formProject' => $form->createView(),
        ]);
    }

    /**
     * @Route("/list/{id}", name="project_list")
     */
    public function showProjects($id) {
        $repo = $this->getDoctrine()->getRepository(Project::class);
        $projects = $repo->findBy(array('user' => $id));
        $form = $this->createFormBuilder()
            ->add('name', TextType::class)
            ->add('save', SubmitType::class, ['label' => 'Remove Project'])
            ->getForm();
        $form->handleRequest($request);
        return $this->render('user/form_list.html.twig', [
            'formRemove' => $form->createView(),
            'projects' => $projects,
        ]);
    }
}
