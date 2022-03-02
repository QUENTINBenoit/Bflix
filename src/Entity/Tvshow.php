<?php

namespace App\Entity;

use App\Repository\TvshowRepository;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Stringable;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: TvshowRepository::class)]
class Tvshow
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 25)]
    #[Assert\NotBlank(message: 'Merci de saisir un titre pour la série demandée')]
    private $title;

    #[ORM\Column(type: 'text', nullable: true)]
    private $synopsis;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $image;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $nbLikes;

    #[ORM\Column(type: 'datetime')]
    private $publishedAt;

    #[ORM\Column(type: 'datetime')]
    private $createdAt;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private $udaptedAt;

    #[ORM\OneToMany(mappedBy: 'seasons', targetEntity: Season::class,)]
    private $seasons;

    #[ORM\ManyToMany(targetEntity: Character::class, mappedBy: 'charaters')]
    private $characters;

    // #[ORM\ManyToMany(targetEntity: Category::class, mappedBy: 'categories')]
    //private $categories;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $slug;

    #[ORM\ManyToMany(targetEntity: Category::class, mappedBy: 'tvshows',)]
    private $catgoriess;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $poster;

    public function __construct()
    {
        $this->seasons = new ArrayCollection();
        $this->characters = new ArrayCollection();
        $this->categories = new ArrayCollection();
        $this->publishedAt = new DateTime();
        $this->createdAt = new DateTime();
        $this->updatedAt = new DateTime();
        $this->catgoriess = new ArrayCollection();
    }
    /*
    public function __toString(): string
    {
        return $this->title;
    }*/

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getSynopsis(): ?string
    {
        return $this->synopsis;
    }

    public function setSynopsis(?string $synopsis): self
    {
        $this->synopsis = $synopsis;

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

    public function getNbLikes(): ?int
    {
        return $this->nbLikes;
    }

    public function setNbLikes(?int $nbLikes): self
    {
        $this->nbLikes = $nbLikes;

        return $this;
    }

    public function getPublishedAt(): ?\DateTimeInterface
    {
        return $this->publishedAt;
    }

    public function setPublishedAt(\DateTimeInterface $publishedAt): self
    {
        $this->publishedAt = $publishedAt;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUdaptedAt(): ?\DateTimeInterface
    {
        return $this->udaptedAt;
    }

    public function setUdaptedAt(?\DateTimeInterface $udaptedAt): self
    {
        $this->udaptedAt = $udaptedAt;

        return $this;
    }

    /**
     * @return Collection|Season[]
     */
    public function getSeasons(): Collection
    {
        return $this->seasons;
    }

    public function addSeason(Season $season): self
    {
        if (!$this->seasons->contains($season)) {
            $this->seasons[] = $season;
            $season->setSeasons($this);
        }

        return $this;
    }

    public function removeSeason(Season $season): self
    {
        if ($this->seasons->removeElement($season)) {
            // set the owning side to null (unless already changed)
            if ($season->getSeasons() === $this) {
                $season->setSeasons(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Character[]
     */
    public function getCharacters(): Collection
    {
        return $this->characters;
    }

    public function addCharacter(Character $character): self
    {
        if (!$this->characters->contains($character)) {
            $this->characters[] = $character;
            $character->addCharater($this);
        }

        return $this;
    }

    public function removeCharacter(Character $character): self
    {
        if ($this->characters->removeElement($character)) {
            $character->removeCharater($this);
        }

        return $this;
    }

    /**
     * @return Collection|Category[]
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function addCategory(Category $category): self
    {
        if (!$this->categories->contains($category)) {
            $this->categories[] = $category;
            $category->addCategory($this);
        }

        return $this;
    }

    public function removeCategory(Category $category): self
    {
        if ($this->categories->removeElement($category)) {
            $category->removeCategory($this);
        }

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * @return Collection|Category[]
     */
    public function getCatgoriess(): Collection
    {
        return $this->catgoriess;
    }

    public function addCatgoriess(Category $catgoriess): self
    {
        if (!$this->catgoriess->contains($catgoriess)) {
            $this->catgoriess[] = $catgoriess;
            $catgoriess->addTvshow($this);
        }

        return $this;
    }

    public function removeCatgoriess(Category $catgoriess): self
    {
        if ($this->catgoriess->removeElement($catgoriess)) {
            $catgoriess->removeTvshow($this);
        }

        return $this;
    }

    public function getPoster(): ?string
    {
        return $this->poster;
    }

    public function setPoster(?string $poster): self
    {
        $this->poster = $poster;

        return $this;
    }
}
