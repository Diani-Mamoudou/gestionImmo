<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\DemandeRepository;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=DemandeRepository::class)
 */
class Demande
{
    const TYPE = ["immeuble" => "immeuble", "chambre" => "chambre", "studio" => "studio", "appartement" => "appartement"];
    const TYPEU = ["bureau" => "bureau", "logement" => "logement"];
    const TYPEDEM = ["demReserv" => "demReserv", "reserve" => "reserve"];
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank(message="la description est obligatoire")
     */
    private $description;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $prix;


    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Choice({"immeuble", "chambre", "studio", "appartement"})
     * @Assert\NotBlank(message="le type est obligatoire")
     */
    private $type;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="la zone est obligatoire")
     */
    private $zone;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Choice({"bureau", "chambre", "logement"})php
     * @Assert\NotBlank(message="le type d'usage est obligatoire")
     */
    private $typeUsage;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $loyer;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $photo;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $periode;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $typeDema;

    /**
     * @ORM\OneToOne(targetEntity=Biens::class, cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $bien;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="reservation")
     * @ORM\JoinColumn(nullable=false)
     */
    private $userReserv;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPrix(): ?int
    {
        return $this->prix;
    }

    public function setPrix(?int $prix): self
    {
        $this->prix = $prix;

        return $this;
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

    public function getZone(): ?string
    {
        return $this->zone;
    }

    public function setZone(string $zone): self
    {
        $this->zone = $zone;

        return $this;
    }

    public function getTypeUsage(): ?string
    {
        return $this->typeUsage;
    }

    public function setTypeUsage(string $typeUsage): self
    {
        $this->typeUsage = $typeUsage;

        return $this;
    }

    public function getLoyer(): ?float
    {
        return $this->loyer;
    }

    public function setLoyer(?float $loyer): self
    {
        $this->loyer = $loyer;

        return $this;
    }

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(?string $photo): self
    {
        $this->photo = $photo;

        return $this;
    }

    public function getPeriode(): ?int
    {
        return $this->periode;
    }

    public function setPeriode(?int $periode): self
    {
        $this->periode = $periode;

        return $this;
    }

    public function getTypeDema(): ?string
    {
        return $this->typeDema;
    }

    public function setTypeDema(string $typeDema): self
    {
        $this->typeDema = $typeDema;

        return $this;
    }

    public function getBien(): ?Biens
    {
        return $this->bien;
    }

    public function setBien(Biens $bien): self
    {
        $this->bien = $bien;

        return $this;
    }

    /**
     * Get the value of userReserv
     */ 
    public function getUserReserv()
    {
        return $this->userReserv;
    }

    /**
     * Set the value of userReserv
     *
     * @return  self
     */ 
    public function setUserReserv($userReserv)
    {
        $this->userReserv = $userReserv;

        return $this;
    }
}
