<?php

namespace App\Entity;

use App\Repository\CoursRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CoursRepository::class)]
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
}
