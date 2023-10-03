<?php

namespace App\Entity;

use App\Repository\CharacterRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


#[ORM\Entity(repositoryClass: CharacterRepository::class)]
#[ORM\Table(name: '`character`')]
class Character
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    private ?string $title = null;

    #[ORM\Column(length: 255)]
    private ?string $image = null;

    #[ORM\Column(length: 255)]
    private ?string $gender = null;

    #[ORM\Column(length: 2)]
    private ?string $posision = null;

    #[ORM\ManyToMany(targetEntity: Team::class, inversedBy: 'characters')]
    private Collection $teams;

    public function __construct()
    {
        $this->teams = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): static
    {
        $this->image = $image;

        return $this;
    }

    public function getGender(): ?string
    {
        return $this->gender;
    }

    public function setGender(string $gender): static
    {
        $this->gender = $gender;

        return $this;
    }

    public function getPosision(): ?string
    {
        return $this->posision;
    }

    public function setPosision(string $posision): static
    {
        $this->posision = $posision;

        return $this;
    }

    /**
     * @return Collection<int, teams>
     */
    public function getTeams(): Collection
    {
        return $this->teams;
    }

    public function addTeam(Team $teams): static
    {
        if (!$this->teams->contains($teams)) {
            $this->teams->add($teams);
        }

        return $this;
    }

    public function removeTeam(Team $teams): static
    {
        $this->teams->removeElement($teams);

        return $this;
    }

}
