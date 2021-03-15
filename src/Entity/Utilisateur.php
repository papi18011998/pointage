<?php

namespace App\Entity;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\UtilisateurRepository;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraint as Assert;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass=UtilisateurRepository::class)
 * @Assert\UniqueEntity(
 * fields={login},
 * message="Cet utilisateur existe déjà dans la base"
 * )
 */
class Utilisateur
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
    private $prenom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $login;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(min="8",minMessage="Votre mot de passe doit compter au minimum 8 caractères")
     * @Assert\EqualTo(protertyPath="confirmPassword")
     */
    private $password;
    /**
     *@Assert\EqualTo(protertyPath="confirmPassword", message="Les mots de passe ne correspondent pas")
     */
    private $confirmPassword;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $telephone;

    /**
     * @ORM\OneToMany(targetEntity=Pointage::class, mappedBy="utilisateur")
     */
    private $pointage;

    /**
     * @ORM\OneToMany(targetEntity=Incident::class, mappedBy="utilisateur")
     */
    private $commentaire;

    /**
     * @ORM\OneToOne(targetEntity=Vehicule::class, cascade={"persist", "remove"})
     */
    private $vehicule;

    /**
     * @ORM\OneToOne(targetEntity=Depart::class, cascade={"persist", "remove"})
     */
    private $depart;

    /**
     * @ORM\ManyToOne(targetEntity=Role::class, inversedBy="utilisateurs")
     * @ORM\JoinColumn(nullable=false)
     */
    private $role;

    public function __construct()
    {
        $this->pointage = new ArrayCollection();
        $this->commentaire = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getLogin(): ?string
    {
        return $this->login;
    }

    public function setLogin(string $login): self
    {
        $this->login = $login;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    /**
     * @return Collection|Pointage[]
     */
    public function getPointage(): Collection
    {
        return $this->pointage;
    }

    public function addPointage(Pointage $pointage): self
    {
        if (!$this->pointage->contains($pointage)) {
            $this->pointage[] = $pointage;
            $pointage->setUtilisateur($this);
        }

        return $this;
    }

    public function removePointage(Pointage $pointage): self
    {
        if ($this->pointage->removeElement($pointage)) {
            // set the owning side to null (unless already changed)
            if ($pointage->getUtilisateur() === $this) {
                $pointage->setUtilisateur(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Incident[]
     */
    public function getCommentaire(): Collection
    {
        return $this->commentaire;
    }

    public function addCommentaire(Incident $commentaire): self
    {
        if (!$this->commentaire->contains($commentaire)) {
            $this->commentaire[] = $commentaire;
            $commentaire->setUtilisateur($this);
        }

        return $this;
    }

    public function removeCommentaire(Incident $commentaire): self
    {
        if ($this->commentaire->removeElement($commentaire)) {
            // set the owning side to null (unless already changed)
            if ($commentaire->getUtilisateur() === $this) {
                $commentaire->setUtilisateur(null);
            }
        }

        return $this;
    }

    public function getVehicule(): ?Vehicule
    {
        return $this->vehicule;
    }

    public function setVehicule(?Vehicule $vehicule): self
    {
        $this->vehicule = $vehicule;

        return $this;
    }

    public function getDepart(): ?Depart
    {
        return $this->depart;
    }

    public function setDepart(?Depart $depart): self
    {
        $this->depart = $depart;

        return $this;
    }

    public function getRoles(): ?Role
    {
        return $this->role;
    }

    public function setRole(?Role $role): self
    {
        $this->role = $role;

        return $this;
    }
    private $username;
    public function getUsername()
    {
        return $this->login;
    }
    public function getSalt()
    {
        // leaving blank - I don't need/have a password!
    }
    public function eraseCredentials()
    {
        // leaving blank - I don't need/have a password!

}
}