<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Form\CategorieType;
use App\Repository\CategorieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class CategorieController extends AbstractController
{
    /**
     * @Route("/admin/categorie", name="categorie_index", methods={"GET"})
     */
    public function index(CategorieRepository $categorieRepository): Response
    {
        return $this->render('categorie/index.html.twig', [
            'categories' => $categorieRepository->findAll(),
        ]);
    }

    /**
     * @Route("/led-integree", name="ledintegree", methods={"GET"})
     */
    public function ledintegree(CategorieRepository $categorieRepository): Response
    {
        $categorie = $categorieRepository->findById("1");
        return $this->render('categorie/navoption.html.twig', [
            'categories' => $categorie,
        ]);
    }

    /**
     * @Route("/douille", name="douille", methods={"GET"})
     */
    public function douille(CategorieRepository $categorieRepository): Response
    {
        $categorie = $categorieRepository->findById("2");
        return $this->render('categorie/navoption.html.twig', [
            'categories' => $categorie,
        ]);
    }

    /**
     * @Route("/lampe", name="lampe", methods={"GET"})
     */
    public function lampe(CategorieRepository $categorieRepository): Response
    {
        $categorie = $categorieRepository->findById("3");
        return $this->render('categorie/navoption.html.twig', [
            'categories' => $categorie,
        ]);
    }

    /**
     * @Route("/lampadaire", name="lampadaire", methods={"GET"})
     */
    public function lampadaire(CategorieRepository $categorieRepository): Response
    {
        $categorie = $categorieRepository->findById("4");
        return $this->render('categorie/navoption.html.twig', [
            'categories' => $categorie,
        ]);
    }

    /**
     * @Route("/porte-manteaux", name="portemanteaux", methods={"GET"})
     */
    public function portemanteaux(CategorieRepository $categorieRepository): Response
    {
        $categorie = $categorieRepository->findById("5");
        return $this->render('categorie/navoption.html.twig', [
            'categories' => $categorie,
        ]);
    }


    /**
     * @Route("/admin/categorie/ajouter", name="categorie_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $categorie = new Categorie();
        $form = $this->createForm(CategorieType::class, $categorie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($categorie);
            $entityManager->flush();

            return $this->redirectToRoute('categorie_index');
        }

        return $this->render('categorie/new.html.twig', [
            'categorie' => $categorie,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/categorie/{id}", name="categorie_show", methods={"GET"})
     */
    public function show(Categorie $categorie): Response
    {
        return $this->render('categorie/show.html.twig', [
            'categorie' => $categorie,
        ]);
    }

    /**
     * @Route("/admin/categorie/modifier/{id}", name="categorie_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Categorie $categorie): Response
    {
        $form = $this->createForm(CategorieType::class, $categorie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('categorie_index');
        }

        return $this->render('categorie/edit.html.twig', [
            'categorie' => $categorie,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/categorie/supprimer/{id}", name="categorie_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Categorie $categorie): Response
    {
        if ($this->isCsrfTokenValid('delete'.$categorie->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($categorie);
            $entityManager->flush();
        }

        return $this->redirectToRoute('categorie_index');
    }
    
}
