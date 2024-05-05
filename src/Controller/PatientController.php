<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Patient;
use App\Form\PatientType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\PatientRepository;


class PatientController extends AbstractController
{
    #[Route('/patient', name: 'app_patient')]

    //notre travaille
    public function index(PatientRepository $repo): Response
    {
        $patinet=$repo->findAll();
        return $this->render('patient/index.html.twig', ['patients'=>$patinet,]);
    }






    //notre travaille


    #[Route('/patient/new', name: 'new_patient')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $patient = new Patient();
        $form = $this->createForm(PatientType::class, $patient);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $patient = $form->getData();
            $entityManager->persist($patient);
            $entityManager->flush();
            return $this->redirectToRoute('app_patient');
        }
        return $this->render('patient/new.html.twig', ['form' => $form->createView(),]);
    }


    #[Route('/patient/update/{id}', name: 'update_form') ]
    public function update($id, PatientRepository $repo,Request $request,EntityManagerInterface $entityManager): Response
    {
        $patient = $repo->find($id);
        // $form = $this->createFormBuilder($article)
        // ->add('title', TextType::class)
        // ->add('image',TextType::class)
        // ->add('content', TextType::class)
        // ->add('save', SubmitType::class, ['label' => 'Update Article'])
        // ->getForm();
        $form =$this->createForm(PatientType::class,$patient) ;
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $patient = $form->getData();
            $entityManager->persist($patient);
            $entityManager->flush();
            return $this->redirectToRoute('app_patient');
        }
        return $this->render('patient/new.html.twig', ['form' => $form->createView(),]);
    }



    #[Route('/patient/delete/{id}', name: 'delete_form') ]
    public function delete($id, PatientRepository $repo,EntityManagerInterface $entityManager): Response
    {
        $patient = $repo->find($id);
        $entityManager->remove($patient);
        $entityManager->flush();
        return $this->redirectToRoute('app_patient');
    }

}
