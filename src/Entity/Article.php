<?php

namespace App\Entity;

use App\Repository\ArticleRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ArticleRepository::class)
 */
class Article
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
    private $type;

    /**
     * @ORM\Column(type="float")
     */
    private $prixAchat;

    /**
     * @ORM\Column(type="float")
     */
    private $prixVente;

    /**
     * @ORM\Column(type="integer")
     */
    private $stock;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $qteVendu;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getPrixAchat(): ?float
    {
        return $this->prixAchat;
    }

    public function setPrixAchat(float $prixAchat): self
    {
        $this->prixAchat = $prixAchat;

        return $this;
    }

    public function getPrixVente(): ?float
    {
        return $this->prixVente;
    }

    public function setPrixVente(float $prixVente): self
    {
        $this->prixVente = $prixVente;

        return $this;
    }

    public function getStock(): ?int
    {
        return $this->stock;
    }

    public function setStock(int $stock): self
    {
        $this->stock = $stock;

        return $this;
    }

    public function getQteVendu(): ?int
    {
        return $this->qteVendu;
    }

    public function setQteVendu(?int $qteVendu): self
    {
        $this->qteVendu = $qteVendu;

        return $this;
    }
}
