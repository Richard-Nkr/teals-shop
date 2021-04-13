<?php

namespace App\Entity;

use App\Repository\DeliverySlipRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DeliverySlipRepository::class)
 */
class DeliverySlip
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity=Client::class, inversedBy="deliverySlip", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $client;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $adressRelai;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $ville;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $codePostal;

    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     */
    private $paysISO;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $codeRelay;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $poids = 500;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(Client $client): self
    {
        $this->client = $client;

        return $this;
    }

    public function getAdressRelai(): ?string
    {
        return $this->adressRelai;
    }

    public function setAdressRelai(?string $adressRelai): self
    {
        $this->adressRelai = $adressRelai;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(?string $ville): self
    {
        $this->ville = $ville;

        return $this;
    }

    public function getCodePostal(): ?int
    {
        return $this->codePostal;
    }

    public function setCodePostal(?int $codePostal): self
    {
        $this->codePostal = $codePostal;

        return $this;
    }

    public function getPaysISO(): ?string
    {
        return $this->paysISO;
    }

    public function setPaysISO(?string $paysISO): self
    {
        $this->paysISO = $paysISO;

        return $this;
    }

    public function getCodeRelay(): ?int
    {
        return $this->codeRelay;
    }

    public function setCodeRelay(?int $codeRelay): self
    {
        $this->codeRelay = $codeRelay;

        return $this;
    }

    public function getPoids(): ?int
    {
        return $this->poids;
    }

    public function setPoids(?int $poids): self
    {
        $this->poids = $poids;

        return $this;
    }

}
