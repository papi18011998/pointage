<?php

namespace App\Entity;

use App\Repository\IncidentRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=IncidentRepository::class)
 */
class Incident
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     */
    private $dateIncident;

    /**
     * @ORM\Column(type="time")
     */
    private $heureIncident;

    /**
     * @ORM\Column(type="string", length=1000)
     */
    private $commentaire;

    /**
     * @ORM\ManyToOne(targetEntity=Utilisateur::class, inversedBy="commentaire")
     * @ORM\JoinColumn(nullable=false)
     */
    private $utilisateur;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateIncident(): ?\DateTimeInterface
    {
        return $this->dateIncident;
    }

    public function setDateIncident(\DateTimeInterface $dateIncident): self
    {
        $this->dateIncident = $dateIncident;

        return $this;
    }

    public function getHeureIncident(): ?\DateTimeInterface
    {
        return $this->heureIncident;
    }

    public function setHeureIncident(\DateTimeInterface $heureIncident): self
    {
        $this->heureIncident = $heureIncident;

        return $this;
    }

    public function getCommentaire(): ?string
    {
        return $this->commentaire;
    }

    public function setCommentaire(string $commentaire): self
    {
        $this->commentaire = $commentaire;

        return $this;
    }

    public function getUtilisateur(): ?Utilisateur
    {
        return $this->utilisateur;
    }

    public function setUtilisateur(?Utilisateur $utilisateur): self
    {
        $this->utilisateur = $utilisateur;

        return $this;
    }
}
