<?php

namespace App\Entity;

use App\Repository\JobRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Traits\TimeStampTrait;

#[ORM\Entity(repositoryClass: JobRepository::class)]
#[ORM\HasLifecycleCallbacks()]
class Job
{
    use TimeStampTrait; 
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 70)]
    private ?string $designation = null;

    #[ORM\OneToMany(mappedBy: 'job', targetEntity: Persone::class)]
    private Collection $persones;

    public function __construct()
    {
        $this->persones = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDesignation(): ?string
    {
        return $this->designation;
    }

    public function setDesignation(string $designation): self
    {
        $this->designation = $designation;

        return $this;
    }

    /**
     * @return Collection<int, Persone>
     */
    public function getPersones(): Collection
    {
        return $this->persones;
    }

    public function addPersone(Persone $persone): self
    {
        if (!$this->persones->contains($persone)) {
            $this->persones->add($persone);
            $persone->setJob($this);
        }

        return $this;
    }

    public function removePersone(Persone $persone): self
    {
        if ($this->persones->removeElement($persone)) {
            // set the owning side to null (unless already changed)
            if ($persone->getJob() === $this) {
                $persone->setJob(null);
            }
        }

        return $this;
    }
}
