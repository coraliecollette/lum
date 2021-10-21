<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Form\ProduitType;
use App\Repository\ProduitRepository;
use App\Twig\CatsExtension;
use Doctrine\ORM\EntityManagerInterface as EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProduitController extends AbstractController
{
    /**
     * @Route("/produit", name="produit")
     */
    public function index(ProduitRepository $pr): Response
    {
        return $this->render('produit/index.html.twig', [
            'produits' => $pr->findAll(),
        ]);
    }

    /**
     * @Route("/admin/produit/nouveau", name="produit_nouveau")
     */
    public function nouveau(Request $rq, EntityManager $em)
    {
        if ($rq->isMethod("POST")) {
            $nouveauProduit = new Produit;
            $titre = $rq->request->get("titre");
            $couleur = $rq->request->get("couleur");
            $photo = $rq->request->get("photo");
            $Flux = $rq->request->get("Flux");
            $Watt = $rq->request->get("Watt");
            $Tdecouleur = $rq->request->get("Tdecouleur");
            $Classe = $rq->request->get("Classe");
            $Energieclass = $rq->request->get("Energieclass");
            $Fonction = $rq->request->get("Fonction");
            $description = $rq->request->get("description");
            // $categorie = $rq->request->get("categorie");

            if (!empty($titre)) {
                $nouveauProduit->setTitre($titre);
                $nouveauProduit->setCouleur($couleur);
                $nouveauProduit->setPhoto($photo);
                $nouveauProduit->setFlux($Flux);
                $nouveauProduit->setWatt($Watt);
                $nouveauProduit->setTdecouleur($Tdecouleur);
                $nouveauProduit->setClasse($Classe);
                $nouveauProduit->setEnergieclass($Energieclass);
                $nouveauProduit->setFonction($Fonction);
                $nouveauProduit->setDescription($description);
                // $nouveauProduit->setCategorie($categorie);

                $em->persist($nouveauProduit);
                $em->flush();

                return $this->redirectToRoute("produit");
            }
        }
        return $this->render("produit/formulaire.html.twig");
    }

    /**
     * @Route("/admin/produit/ajouter", name="produit_ajouter")
     */

    public function ajouter(Request $rq, EntityManager $em)
    {
        $produit = new Produit;
        $form = $this->createForm(ProduitType::class, $produit);
        $form->handleRequest($rq);
        if ($form->isSubmitted() && $form->isValid()) {
            $image = $form->get("photo")->getData();
            $image2 = $form->get("Energieclass")->getData();
            $image3 = $form->get("Fonction")->getData();

            if (
                !empty($image)
                && !empty($image2)
                && !empty($image3)
            ) {
                $nomFichier = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                $nomFichier2 = pathinfo($image2->getClientOriginalName(), PATHINFO_FILENAME);
                $nomFichier3 = pathinfo($image3->getClientOriginalName(), PATHINFO_FILENAME);
                $nomFichier .= uniqid();
                $nomFichier2 .= uniqid();
                $nomFichier3 .= uniqid();
                $nomFichier .= "." . $image->guessExtension();
                $nomFichier2 .= "." . $image2->guessExtension();
                $nomFichier3 .= "." . $image3->guessExtension();
                $nomFichier = str_replace(" ", "_", $nomFichier);
                $nomFichier2 = str_replace(" ", "_", $nomFichier2);
                $nomFichier3 = str_replace(" ", "_", $nomFichier3);
                $image->move($this->getParameter("dossier_images"), $nomFichier);
                $image2->move($this->getParameter("dossier_images"), $nomFichier2);
                $image3->move($this->getParameter("dossier_images"), $nomFichier3);
                $produit->setPhoto($nomFichier);
                $produit->setEnergieclass($nomFichier2);
                $produit->setFonction($nomFichier3);
            }

            $em->persist($produit);
            $em->flush();
            return $this->redirectToRoute("produit");
        }

        return $this->render("produit/ajouter.html.twig", ["formProduit" => $form->createView()]);
    }

    /**
     * @Route("/produit-detail/{id}", name="produit_detail")
     * 
     */
    public function produitDetail($id, ProduitRepository $pr)
    {
        return $this->render("produit/fiche.html.twig", ["produit" => $pr->find($id)]);
    }

    /**
     * @Route("/admin/produit/modifier/{id}", name="produit_modifier")
     */

    public function modifier($id, ProduitRepository $pr, Request $rq, EntityManager $em)
    {

        $produit = $pr->find($id);
        $form = $this->createForm(ProduitType::class, $produit);
        $form->handleRequest($rq);


        if ($form->isSubmitted() && $form->isValid()) {
            $image = $form->get("photo")->getData();
            $image2 = $form->get("Energieclass")->getData();
            $image3 = $form->get("Fonction")->getData();

            if (!empty($image)) {
                // SUPPRIMER ANCIENNE PHOTO
                $ancienneimg = $this->getParameter("dossier_images") . '/' . $produit->getPhoto();

                if (file_exists($ancienneimg)) {
                    unlink($ancienneimg);
                }

                $nomFichier = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                $nomFichier .= uniqid();
                $nomFichier .= "." . $image->guessExtension();
                $nomFichier = str_replace(" ", "_", $nomFichier);
                $image->move($this->getParameter("dossier_images"), $nomFichier);
                $produit->setPhoto($nomFichier);
            }

            if (!empty($image2)) {

                $ancienneimg2 = $this->getParameter("dossier_images") . '/' . $produit->getEnergieclass();

                if (file_exists($ancienneimg2)) {
                    unlink($ancienneimg2);
                }

                $nomFichier2 = pathinfo($image2->getClientOriginalName(), PATHINFO_FILENAME);
                $nomFichier2 .= uniqid();
                $nomFichier2 .= "." . $image2->guessExtension();
                $nomFichier2 = str_replace(" ", "_", $nomFichier2);
                $image2->move($this->getParameter("dossier_images"), $nomFichier2);
                $produit->setEnergieclass($nomFichier2);
            }

            if (!empty($image2)) {

                $ancienneimg3 = $this->getParameter("dossier_images") . '/' . $produit->getFonction();

                if (file_exists($ancienneimg3)) {
                    unlink($ancienneimg3);
                }

                $nomFichier3 = pathinfo($image3->getClientOriginalName(), PATHINFO_FILENAME);
                $nomFichier3 .= uniqid();
                $nomFichier3 .= "." . $image3->guessExtension();
                $nomFichier3 = str_replace(" ", "_", $nomFichier3);
                $image3->move($this->getParameter("dossier_images"), $nomFichier3);
                $produit->setFonction($nomFichier3);
            }


            $em->flush();
            return $this->render("produit/fiche.html.twig", ["produit" => $pr->find($id)]);
        }
        return $this->render("produit/modifier.html.twig", [
            "formProduit" => $form->createView(),
            "titre" => "Modifier"
        ]);
    }

    /**
     * @Route("/admin/produit/supprimer/{id}", name="produit_supprimer")
     */

    public function supprimer($id, ProduitRepository $pr, Request $rq, EntityManager $em)
    {
        $produit = $pr->find($id);
        if (empty($produit)) {
            $this->addFlash("danger", "Il n'y a pas de produit avec l'identifiant $id");
            return $this->redirectToRoute("produit");
        }

        //    SUPPRIMER LA PHOTO DE LA BDD QUAND LE PRODUIT EST SUPPRIMÉ

        $photo = $produit->getPhoto();
        if ($photo) {
            $nomFichier = $this->getParameter("dossier_images") . '/' . $produit->getPhoto();

            if (file_exists($nomFichier)) {
                unlink($nomFichier);
            }
        }

        $Energieclass = $produit->getEnergieclass();
        if ($Energieclass) {
            $nomFichier1 = $this->getParameter("dossier_images") . '/' . $produit->getEnergieclass();

            if (file_exists($nomFichier1)) {
                unlink($nomFichier1);
            }
        }
        $Fonction = $produit->getFonction();
        if ($Fonction) {
            $nomFichier2 = $this->getParameter("dossier_images") . '/' . $produit->getFonction();

            if (file_exists($nomFichier2)) {
                unlink($nomFichier2);
            }
        }


        // MAJ BDD LORSQUE LE PRODUIT EST SUPPRIMÉ

        if ($rq->isMethod("POST")) {
            $em->remove($produit);
            $em->flush();
            return $this->redirectToRoute("produit");
        }
        return $this->render("produit/supprimer.html.twig", ["produit" => $produit]);
    }
}
