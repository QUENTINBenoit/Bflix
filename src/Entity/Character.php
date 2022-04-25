<?php

namespace App\Entity;

use App\Repository\CharacterRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Stringable;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: CharacterRepository::class)]
#[ORM\Table(name: '`character`')]
class Character implements Stringable
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups('groupsTvshows')]
    private $id;

    #[ORM\Column(type: 'string', length: 50)]
    #[Groups('groupsTvshows')]
    private $firstname;

    #[ORM\Column(type: 'string', length: 50)]
    #[Groups('groupsTvshows')]
    private $lastname;

    #[ORM\Column(type: 'string', length: 25)]
    #[Groups('groupsTvshows')]
    private $gender;

    #[ORM\Column(type: 'text', nullable: true)]
    #[Groups('groupsTvshows')]
    private $bio;

    #[ORM\Column(type: 'smallint')]
    #[Groups('groupsTvshows')]
    private $age;

    #[ORM\ManyToMany(targetEntity: Tvshow::class, mappedBy: 'characters')]

    private $charaters;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]

    private $image;

    public function __construct()
    {
        $this->charaters = new ArrayCollection();
    }
    public function __toString(): string
    {
        return $this->firstname;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getGender(): ?string
    {
        return $this->gender;
    }

    public function setGender(string $gender): self
    {
        $this->gender = $gender;

        return $this;
    }

    public function getBio(): ?string
    {
        return $this->bio;
    }

    public function setBio(?string $bio): self
    {
        $this->bio = $bio;

        return $this;
    }

    public function getAge(): ?int
    {
        return $this->age;
    }

    public function setAge(int $age): self
    {
        $this->age = $age;

        return $this;
    }

    /**
     * @return Collection|Tvshow[]
     */
    public function getCharaters(): Collection
    {
        return $this->charaters;
    }

    public function addCharater(Tvshow $charater): self
    {
        if (!$this->charaters->contains($charater)) {
            $this->charaters[] = $charater;
        }

        return $this;
    }

    public function removeCharater(Tvshow $charater): self
    {
        $this->charaters->removeElement($charater);

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }
}
