<?php
/**
 * Created by PhpStorm.
 * User: Glody TIRI
 * Date: 07/12/2018
 * Time: 14:14
 */

namespace App\Controller;

use App\Entity\Project;
use App\Entity\Upload;
use App\Form\UploadType;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


class UploadController extends AbstractController
{
    /**
     * @Route("/add_file/{id}", name="file")
     */
    public function AddFile($id, Request $request, ObjectManager $manager)
    {
        $upload = new Upload();
        $form = $this->createForm(UploadType::class, $upload);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $file = $upload->getName();
            //$fileName = md5(uniqid()).'.'.$file->guessExtension();
            $extension = $file->getExtension();
            if(($extension == "csv") && (($handle = fopen($file,"r")) == TRUE)){
                $sep = ";";
                foreach ($file as $File){
                    $FileName = implode($sep,$File);
                    move_uploaded_file($FileName, $this->getParameter('upload_directory'));
                    $repo = $this->getDoctrine()->getRepository(Project::class);
                    $id_Project = $repo->find($id);
                    $upload->setIdProject($id_Project);
                    $manager->persist($upload);
                    $manager->flush();
                }
            }else {
                move_uploaded_file($file,$this->getParameter('upload_directory'));
                $repo = $this->getDoctrine()->getRepository(Project::class);
                $id_Project = $repo->find($id);
                $upload->setIdProject($id_Project);
                $manager->persist($upload);
                $manager->flush();
            }
            return $this->redirectToRoute('AddFile');
        }
        return $this->render('user/form_source.html.twig', array(
            'formFile' => $form->createView(),
        ));
    }

}