<?php

namespace App\Entity;

use App\Repository\CommandeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CommandeRepository::class)
 */
class Commande
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $color;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $size;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $promo;

    /**
     * @ORM\ManyToOne(targetEntity=Live::class, inversedBy="commandes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $live;

    /**
     * @ORM\Column(type="integer")
     */
    private $quantite;
    
    /**
     * @ORM\Column(type="integer")
     */
    private $panier;

    /**
     * @ORM\Column(type="integer")
     */
    private $article;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function setColor(string $color): self
    {
        $this->color = $color;

        return $this;
    }

    public function getSize(): ?string
    {
        return $this->size;
    }

    public function setSize(?string $size): self
    {
        $this->size = $size;

        return $this;
    }

    public function getPromo(): ?float
    {
        return $this->promo;
    }

    public function setPromo(?float $promo): self
    {
        $this->promo = $promo;

        return $this;
    }

    public function getLive(): ?Live
    {
        return $this->live;
    }

    public function setLive(?Live $live): self
    {
        $this->live = $live;

        return $this;
    }

    public function getQuantite(): ?int
    {
        return $this->quantite;
    }

    public function setQuantite(int $quantite): self
    {
        $this->quantite = $quantite;

        return $this;
    }

    public function getPanier(): ?int
    {
        return $this->panier;
    }

    public function setPanier(int $panier): self
    {
        $this->panier = $panier;

        return $this;
    }

    public function getArticle(): ?int
    {
        return $this->article;
    }

    public function setArticle(int $article): self
    {
        $this->article = $article;

        return $this;
    }
}
