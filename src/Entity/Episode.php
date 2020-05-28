<?php

namespace App\Entity;

use App\Repository\EpisodeRepository;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EpisodeRepository::class)
 * @UniqueEntity("title", message="ce titre d'épisode existe déjà")
 */
class Episode
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Assert\NotBlank(message="le titre doit être complété")
     * @Assert\Length(max="255", maxMessage="Le nom de l'épisode saisi '{{ value }}' est trop long, il ne devrait pas dépasser {{ limit }} caractères")
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @Assert\NotBlank()
     * @Assert\Type("integer")
     * @Assert\Length(max="3")
     * @ORM\Column(type="integer")
     */
    private $number;

    /**
     * @Assert\NotBlank(message="le synopsis doit être complété")
     * @Assert\Length(max="500", maxMessage="La synopsis ne doit pas dépasser {{ limit }} caractères, merci.")
     * @ORM\Column(type="text")
     */
    private $synopsis;

    /**
     * @Assert\Length(max="3")
     * @ORM\ManyToOne(targetEntity=Season::class, inversedBy="episodes")
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    private $season;


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

    public function getNumber(): ?int
    {
        return $this->number;
    }

    public function setNumber(int $number): self
    {
        $this->number = $number;

        return $this;
    }

    public function getSynopsis(): ?string
    {
        return $this->synopsis;
    }

    public function setSynopsis(string $synopsis): self
    {
        $this->synopsis = $synopsis;

        return $this;
    }

    public function getSeason(): ?Season
    {
        return $this->season;
    }

    public function setSeason(?Season $season): self
    {
        $this->season = $season;

        return $this;
    }
}
