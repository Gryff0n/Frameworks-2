<?php

namespace App\Entity;

use App\Repository\CoursRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity(repositoryClass: CoursRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Cours
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column]
    private ?int $semestre = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $Description = null;

    #[ORM\Column]
    private ?int $ECTS = null;

    #[ORM\Column]
    private ?int $heureCM = null;

    #[ORM\Column]
    private ?int $heureTD = null;

    #[ORM\Column]
    private ?int $heureTP = null;

    #[ORM\ManyToMany(targetEntity: Formation::class, inversedBy: 'cours')]
    private Collection $formations;

    public function __construct()
    {
        $this->formations = new ArrayCollection();
        $this->enseignants = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getSemestre(): ?int
    {
        return $this->semestre;
    }

    public function setSemestre(int $semestre): static
    {
        $this->semestre = $semestre;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->Description;
    }

    public function setDescription(string $Description): static
    {
        $this->Description = $Description;

        return $this;
    }

    public function getECTS(): ?int
    {
        return $this->ECTS;
    }

    public function setECTS(int $ECTS): static
    {
        $this->ECTS = $ECTS;

        return $this;
    }

    public function getHeureCM(): ?int
    {
        return $this->heureCM;
    }

    public function setHeureCM(int $heureCM): static
    {
        $this->heureCM = $heureCM;

        return $this;
    }

    public function getHeureTD(): ?int
    {
        return $this->heureTD;
    }

    public function setHeureTD(int $heureTD): static
    {
        $this->heureTD = $heureTD;

        return $this;
    }

    public function getHeureTP(): ?int
    {
        return $this->heureTP;
    }

    public function setHeureTP(int $heureTP): static
    {
        $this->heureTP = $heureTP;

        return $this;
    }

    /**
     * @return Collection<int, Formation>
     */
    public function getFormations(): Collection
    {
        return $this->formations;
    }

    public function addFormation(Formation $formation): static
    {
        if (!$this->formations->contains($formation)) {
            $this->formations->add($formation);
        }

        return $this;
    }

    public function removeFormation(Formation $formation): static
    {
        $this->formations->removeElement($formation);

        return $this;
    }


    #[ORM\Column(type: 'datetime')]
    private ?\DateTimeInterface $dateCreation = null;

    #[ORM\Column(type: 'datetime')]
    private ?\DateTimeInterface $dateModification = null;

    /**
     * @var Collection<int, User>
     */
    #[ORM\ManyToMany(targetEntity: User::class, inversedBy: 'coursEnseignants')]
    private Collection $enseignants;

    #[ORM\ManyToOne(inversedBy: 'coursResponsable')]
    private ?User $responsable = null;

    #[ORM\PrePersist]
    public function setDateCreationValue(): void
    {
        $this->dateCreation = new \DateTime();
        $this->dateModification = new \DateTime();
    }

    #[ORM\PreUpdate]
    public function setDateModificationValue(): void
    {
        $this->dateModification = new \DateTime();
    }

    public function getDateCreation(): ?\DateTimeInterface
    {
        return $this->dateCreation;
    }

    public function getDateModification(): ?\DateTimeInterface
    {
        return $this->dateModification;
    }

    /**
     * @return Collection<int, User>
     */
    public function getEnseignants(): Collection
    {
        return $this->enseignants;
    }

    public function addEnseignant(User $enseignant): static
    {
        if (!$this->enseignants->contains($enseignant)) {
            $this->enseignants->add($enseignant);
        }

        return $this;
    }

    public function removeEnseignant(User $enseignant): static
    {
        $this->enseignants->removeElement($enseignant);

        return $this;
    }

    public function getResponsable(): ?User
    {
        return $this->responsable;
    }

    public function setResponsable(?User $responsable): static
    {
        $this->responsable = $responsable;

        return $this;
    }

}
