<?php

namespace App\Entity;

use App\Repository\ProgramRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity(repositoryClass=ProgramRepository::class)
 * @UniqueEntity("title", message="ce titre existe déjà")
 */
class Program
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="le tite ne peut pas être vide")
     * @Assert\Length(max="255", maxMessage="Le titre du program saisi{{ value }} est trop long, il ne devrait pas dépasser {{ limit }} caractères")
     */

    private $title;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank(message="le résumé ne peut pas être vide")
     * @Assert\Regex(pattern="/plus belle la vie/i", match=false,
     *      message="On parle de vraies séries ici")
     */
    private $summary;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $poster;

    /**
     * @Assert\NotBlank()
     * @ORM\ManyToOne(targetEntity=Category::class, inversedBy="programs")
     * @ORM\JoinColumn(nullable=false)
     */
    private $category;

    /**
     * @Assert\NotBlank(message="Le pays doit être complété")
     * @Assert\Length(max="255", maxMessage="La pays saisie '{{ value }}' est trop long, il ne devrait pas dépasser {{ limit }} caractères")
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $country;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Assert\NotBlank(message="l'année doit être complétée")
     * @Assert\Length(min="4", max="4", exactMessage="L'année doit être du format YYYY")
     */
    private $year;
    /**
     * @ORM\OneToMany(targetEntity=Season::class, mappedBy="program")
     */
    private $seasons;

    /**
     * @ORM\ManyToMany(targetEntity=Actor::class, mappedBy="programs")
     */
    private $actors;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $slug;

    public function __construct()
    {
        $this->seasons = new ArrayCollection();
        $this->actors = new ArrayCollection();
    }

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

    public function getSummary(): ?string
    {
        return $this->summary;
    }

    public function setSummary(string $summary): self
    {
        $this->summary = $summary;

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

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(string $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function getYear(): ?int
    {
        return $this->year;
    }

    public function setYear(int $year): self
    {
        $this->year = $year;

        return $this;
    }

    /**
     * @return Collection|Season[]
     */
    public function getSeasons(): Collection
    {
        return $this->seasons;
    }
    /**
     * @param Season $season
     * @return Program
     */
    private function addSeason(Season $season):self
    {
        if (!$this->seasons->contains($season)){
            $this->seasons[] = $season;
            $season->setProgram($this);
        }
        return $this;
    }


    /**
     * @param Season $season
     * @return Program
     */
    private function removeSeason(Season $season):self
    {
        if ($this->seasons->contains($season)){
            $this->seasons->removeElement($season);
            // set the owning side to null (unless already changed)
            if ($season->getProgram()=== $this){
                $season->setProgram(null);
            }
        }
        return $this;
    }

    /**
     * @return Collection|Actor[]
     */
    public function getActors(): Collection
    {
        return $this->actors;
    }

    public function addActor(Actor $actor): self
    {
        if (!$this->actors->contains($actor)) {
            $this->actors[] = $actor;
            $actor->addProgram($this);
        }

        return $this;
    }

    public function removeActor(Actor $actor): self
    {
        if ($this->actors->contains($actor)) {
            $this->actors->removeElement($actor);
            $actor->removeProgram($this);
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
}
