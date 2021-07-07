<?php

namespace App\Entity;

use App\Repository\DiseaseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DiseaseRepository::class)
 */
class Disease
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @ORM\OneToMany(targetEntity=Medecine::class, mappedBy="diseases")
     */
    private $medecines;

    public function __construct()
    {
        $this->medecines = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection|Medecine[]
     */
    public function getMedecines(): Collection
    {
        return $this->medecines;
    }

    public function addMedecine(Medecine $medecine): self
    {
        if (!$this->medecines->contains($medecine)) {
            $this->medecines[] = $medecine;
            $medecine->setDiseases($this);
        }

        return $this;
    }

    public function removeMedecine(Medecine $medecine): self
    {
        if ($this->medecines->removeElement($medecine)) {
            // set the owning side to null (unless already changed)
            if ($medecine->getDiseases() === $this) {
                $medecine->setDiseases(null);
            }
        }

        return $this;
    }
}
