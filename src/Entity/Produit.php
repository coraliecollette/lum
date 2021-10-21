<?php

namespace App\Entity;

use App\Repository\ProduitRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity(repositoryClass=ProduitRepository::class)
 */
class Produit
{  
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $titre;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $couleur;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $photo;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Flux;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Watt;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Tdecouleur;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Classe;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Energieclass;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Fonction;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\ManyToMany(targetEntity=Categorie::class, inversedBy="produits")
     */
    private $categories;

    public function __construct()
    {
        $this->categories = new ArrayCollection();
    }



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getCouleur(): ?string
    {
        return $this->couleur;
    }

    public function setCouleur(string $couleur): self
    {
        $this->couleur = $couleur;

        return $this;
    }

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(string $photo): self
    {
        $this->photo = $photo;

        return $this;
    }

    public function getFlux(): ?string
    {
        return $this->Flux;
    }

    public function setFlux(string $Flux): self
    {
        $this->Flux = $Flux;

        return $this;
    }

    public function getWatt(): ?string
    {
        return $this->Watt;
    }

    public function setWatt(string $Watt): self
    {
        $this->Watt = $Watt;

        return $this;
    }

    public function getTdecouleur(): ?string
    {
        return $this->Tdecouleur;
    }

    public function setTdecouleur(string $Tdecouleur): self
    {
        $this->Tdecouleur = $Tdecouleur;

        return $this;
    }

    public function getClasse(): ?string
    {
        return $this->Classe;
    }

    public function setClasse(string $Classe): self
    {
        $this->Classe = $Classe;

        return $this;
    }

    public function getEnergieclass(): ?string
    {
        return $this->Energieclass;
    }

    public function setEnergieclass(string $Energieclass): self
    {
        $this->Energieclass = $Energieclass;

        return $this;
    }

    public function getFonction(): ?string
    {
        return $this->Fonction;
    }

    public function setFonction(string $Fonction): self
    {
        $this->Fonction = $Fonction;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection|Categorie[]
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function addCategory(Categorie $category): self
    {
        if (!$this->categories->contains($category)) {
            $this->categories[] = $category;
        }

        return $this;
    }

    public function removeCategory(Categorie $category): self
    {
        $this->categories->removeElement($category);

        return $this;
    }

 

}
