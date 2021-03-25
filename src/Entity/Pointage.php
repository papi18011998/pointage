<?php

namespace App\Entity;

use App\Repository\PointageRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PointageRepository::class)
 */
class Pointage
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="time")
     */
    private $heureArrivee;

    /**
     * @ORM\Column(type="time")
     */
    private $heurSortie;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $PointDeLivraison;

    /**
     * @ORM\Column(type="string", length=1000,nullable=true)
     */
    private $commentaire;

    /**
     * @ORM\ManyToOne(targetEntity=Utilisateur::class, inversedBy="pointage")
     */
    private $utilisateur;

    /**
     * @ORM\ManyToOne(targetEntity=Livraison::class, inversedBy="pointages")
     */
    private $livraison;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getHeureArrivee(): ?\DateTimeInterface
    {
        return $this->heureArrivee;
    }

    public function setHeureArrivee(\DateTimeInterface $heureArrivee): self
    {
        $this->heureArrivee = $heureArrivee;

        return $this;
    }

    public function getHeurSortie(): ?\DateTimeInterface
    {
        return $this->heurSortie;
    }

    public function setHeurSortie(\DateTimeInterface $heurSortie): self
    {
        $this->heurSortie = $heurSortie;

        return $this;
    }

    public function getPointDeLivraison(): ?string
    {
        return $this->PointDeLivraison;
    }

    public function setPointDeLivraison(string $PointDeLivraison): self
    {
        $this->PointDeLivraison = $PointDeLivraison;

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

    public function getLivraison(): ?Livraison
    {
        return $this->livraison;
    }

    public function setLivraison(?Livraison $livraison): self
    {
        $this->livraison = $livraison;

        return $this;
    }
}
