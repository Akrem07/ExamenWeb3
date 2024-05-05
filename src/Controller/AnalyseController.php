<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

use App\Entity\Analyse;
use App\Form\AnalyseType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\AnalyseRepository;


class AnalyseController extends AbstractController
{
    #[Route('/analyse', name: 'app_analyse')]

    //notre travaille
    public function index(AnalyseRepository $repo): Response
    {
        $analyse=$repo->findAll();
        return $this->render('analyse/index.html.twig', ['analyses'=>$analyse,]);
    }



    //notre travaille

    #[Route('/analyse/new', name: 'new_analyse')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $analyse = new Analyse();
        $form = $this->createForm(AnalyseType::class, $analyse);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $analyse = $form->getData();
            $entityManager->persist($analyse);
            $entityManager->flush();
            return $this->redirectToRoute('app_analyse');
        }
        return $this->render('analyse/new.html.twig', ['form' => $form->createView(),]);
    }



    #[Route('/analyse/update/{id}', name: 'update_analyse') ]
    public function update($id, AnalyseRepository $repo,Request $request,EntityManagerInterface $entityManager): Response
    {
        $analyse = $repo->find($id);
        // $form = $this->createFormBuilder($article)
        // ->add('title', TextType::class)
        // ->add('image',TextType::class)
        // ->add('content', TextType::class)
        // ->add('save', SubmitType::class, ['label' => 'Update Article'])
        // ->getForm();
        $form =$this->createForm(AnalyseType::class,$analyse) ;
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $analyse = $form->getData();
            $entityManager->persist($analyse);
            $entityManager->flush();
            return $this->redirectToRoute('app_analyse');
        }
        return $this->render('analyse/new.html.twig', ['form' => $form->createView(),]);
    }



    #[Route('/analyse/delete/{id}', name: 'delete_analyse') ]
    public function delete($id, AnalyseRepository $repo,EntityManagerInterface $entityManager): Response
    {
        $analyse = $repo->find($id);
        $entityManager->remove($analyse);
        $entityManager->flush();
        return $this->redirectToRoute('app_analyse');
    }



}
