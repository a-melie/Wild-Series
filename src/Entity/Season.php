<?php

namespace App\Entity;

use App\Repository\SeasonRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SeasonRepository::class)
 * @UniqueEntity(fields={"program","number"}, errorPath="number", message="Cette saison existe déjà.")
 */
class Season
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Assert\NotBlank(message="le numéro de saison doit être complété")
     * @Assert\Type("integer")
     * @Assert\Length(max="3")
     * @ORM\Column(type="integer")
     */
    private $number;

    /**
     * @Assert\NotBlank(message="l'année doit être complétée")
     * @Assert\Type("integer")
     * @Assert\Length(min="4", max="4", exactMessage="L'année doit être du format YYYY")
     * @ORM\Column(type="integer")
     */
    private $year;

    /**
     * @Assert\NotBlank(message="la description doit être complétée")
     * @Assert\Length(max="500", maxMessage="La description ne doit pas dépasser {{ limit }} caractères")
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @Assert\NotBlank()
     * @ORM\ManyToOne(targetEntity=Program::class, inversedBy="seasons")
     * @ORM\JoinColumn(nullable=false)
     */
    private $program;

    /**
     * @ORM\OneToMany(targetEntity=Episode::class, mappedBy="season")
     */
    private $episodes;

    public function __construct()
    {
        $this->episodes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumber(): ?int
    {
        return $this->number;
    }

    public function setNumber(int $number): self
    {
        $this->number = $number;

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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getProgram(): ?Program
    {
        return $this->program;
    }

    public function setProgram(?Program $program): self
    {
        $this->program = $program;

        return $this;
    }

    /**
     * @return Collection|Episode[]
     */
    public function getEpisodes(): Collection
    {
        return $this->episodes;
    }

    /**
     * @param Episode $episode
     * @return $this
     */
    public function addEpisode(Episode $episode): self
    {
        if (!$this->episodes->contains($episode)){
            $this->episodes[] = $episode;
            $episode->setSeason($this);
        }
        return $this;
    }

    /**
     * @param Episode $episode
     * @return $this
     */
    public function removeEpisode(Episode $episode): self
    {
        if ($this->episodes->contains($episode)){
            $this->episodes->removeElement($episode);
            // set the owning side to null (unless already changed)
            if ($episode->getSeason()=== $this){
                $episode->setSeason(null);
            }
        }
        return $this;
    }


}
