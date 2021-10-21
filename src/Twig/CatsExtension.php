<?php

namespace App\Twig;

use App\Entity\Categorie;
use Doctrine\ORM\EntityManagerInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class CatsExtension extends AbstractExtension
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em =$em;
    }

    public function getFunctions():array
    {
        return [
            new TwigFunction('cats', [$this, 'getCategorie'])
        ];
    }

    public function getCategorie()
    {
        return $this->em->getRepository(Categorie::class)->findBy([], ['name' => 'ASC']);
    }
}