<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\BiensRepository;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\HttpFoundation\File\File;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints\Choice;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=BiensRepository::class)
 */
class Biens
{
    const TYPE = ["immeuble" => "immeuble", "chambre" => "chambre", "studio" => "studio", "appartement" => "appartement"];
    const TYPEU = ["bureau" => "bureau", "logement" => "logement"];
    const ETAT = ["Libre" => "libre", "louer" => "louer", "Refection" => "Refection", "Encours" => "Encours", "EncoursR" => "EncoursR"];
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="la description est obligatoire")
     */
    private $description;

    /**
     * @ORM\Column(type="float", nullable=true)
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
     * @Assert\Choice({"libre", "louer", "refection","Encours","EncoursR"})
     */
    private $etat = "Encours";

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="bien")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

   

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

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(?float $prix): self
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

    public function getEtat(): ?string
    {
        return $this->etat;
    }

    public function setEtat(string $etat): self
    {
        $this->etat = $etat;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }


}
