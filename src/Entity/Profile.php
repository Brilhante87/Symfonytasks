<?php

namespace App\Entity;

use App\Repository\ProfileRepository;
use Doctrine\ORM\Mapping as ORM;
use App\Traits\TimeStampTrait;

#[ORM\Entity(repositoryClass: ProfileRepository::class)]
#[ORM\HasLifecycleCallbacks()]
class Profile
{
    use TimeStampTrait; 
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $url = null;

    #[ORM\Column(length: 70)]
    private ?string $rs = null;

    #[ORM\OneToOne(mappedBy: 'profile', cascade: ['persist', 'remove'])]
    private ?Persone $persone = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(string $url): self
    {
        $this->url = $url;

        return $this;
    }

    public function getRs(): ?string
    {
        return $this->rs;
    }

    public function setRs(string $rs): self
    {
        $this->rs = $rs;

        return $this;
    }

    public function getPersone(): ?Persone
    {
        return $this->persone;
    }

    public function setPersone(?Persone $persone): self
    {
        // unset the owning side of the relation if necessary
        if ($persone === null && $this->persone !== null) {
            $this->persone->setProfile(null);
        }

        // set the owning side of the relation if necessary
        if ($persone !== null && $persone->getProfile() !== $this) {
            $persone->setProfile($this);
        }

        $this->persone = $persone;

        return $this;
    }
}
