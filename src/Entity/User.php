<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_EMAIL', fields: ['email'])]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180)]
    private ?string $email = null;

    /**
     * @var list<string> The user roles
     */
    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    private ?string $prenom = null;

    #[ORM\Column(length: 255)]
    private ?string $grade = null;

    #[ORM\Column(length: 255)]
    private ?string $composante = null;

    /**
     * @var Collection<int, Formation>
     */
    #[ORM\OneToMany(targetEntity: Formation::class, mappedBy: 'responsable')]
    private Collection $formationsResponsable;

    /**
     * @var Collection<int, Cours>
     */
    #[ORM\ManyToMany(targetEntity: Cours::class, mappedBy: 'enseignants')]
    private Collection $coursEnseignants;

    /**
     * @var Collection<int, Cours>
     */
    #[ORM\OneToMany(targetEntity: Cours::class, mappedBy: 'responsable')]
    private Collection $coursResponsable;

    public function __construct()
    {
        $this->formationsResponsable = new ArrayCollection();
        $this->coursEnseignants = new ArrayCollection();
        $this->coursResponsable = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * @param list<string> $roles
     */
    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Ensure the session doesn't contain actual password hashes by CRC32C-hashing them, as supported since Symfony 7.3.
     */
    public function __serialize(): array
    {
        $data = (array) $this;
        $data["\0".self::class."\0password"] = hash('crc32c', $this->password);

        return $data;
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

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): static
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getGrade(): ?string
    {
        return $this->grade;
    }

    public function setGrade(string $grade): static
    {
        $this->grade = $grade;

        return $this;
    }

    public function getComposante(): ?string
    {
        return $this->composante;
    }

    public function setComposante(string $composante): static
    {
        $this->composante = $composante;

        return $this;
    }

    /**
     * @return Collection<int, Formation>
     */
    public function getFormationsResponsable(): Collection
    {
        return $this->formationsResponsable;
    }

    public function addFormationsResponsable(Formation $formationsResponsable): static
    {
        if (!$this->formationsResponsable->contains($formationsResponsable)) {
            $this->formationsResponsable->add($formationsResponsable);
            $formationsResponsable->setResponsable($this);
        }

        return $this;
    }

    public function removeFormationsResponsable(Formation $formationsResponsable): static
    {
        if ($this->formationsResponsable->removeElement($formationsResponsable)) {
            // set the owning side to null (unless already changed)
            if ($formationsResponsable->getResponsable() === $this) {
                $formationsResponsable->setResponsable(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Cours>
     */
    public function getCoursEnseignants(): Collection
    {
        return $this->coursEnseignants;
    }

    public function addCoursEnseignant(Cours $coursEnseignant): static
    {
        if (!$this->coursEnseignants->contains($coursEnseignant)) {
            $this->coursEnseignants->add($coursEnseignant);
            $coursEnseignant->addEnseignant($this);
        }

        return $this;
    }

    public function removeCoursEnseignant(Cours $coursEnseignant): static
    {
        if ($this->coursEnseignants->removeElement($coursEnseignant)) {
            $coursEnseignant->removeEnseignant($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Cours>
     */
    public function getCoursResponsable(): Collection
    {
        return $this->coursResponsable;
    }

    public function addCoursResponsable(Cours $coursResponsable): static
    {
        if (!$this->coursResponsable->contains($coursResponsable)) {
            $this->coursResponsable->add($coursResponsable);
            $coursResponsable->setResponsable($this);
        }

        return $this;
    }

    public function removeCoursResponsable(Cours $coursResponsable): static
    {
        if ($this->coursResponsable->removeElement($coursResponsable)) {
            // set the owning side to null (unless already changed)
            if ($coursResponsable->getResponsable() === $this) {
                $coursResponsable->setResponsable(null);
            }
        }

        return $this;
    }
}
