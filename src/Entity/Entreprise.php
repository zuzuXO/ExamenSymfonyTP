<?php

namespace App\Entity;

use App\Repository\EntrepriseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EntrepriseRepository::class)]
class Entreprise
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 50)]
    private $nameEntreprise;

    #[ORM\OneToMany(mappedBy: 'entreprise', targetEntity: Pfe::class)]
    private $ListePfe;

    public function __construct()
    {
        $this->ListePfe = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNameEntreprise(): ?string
    {
        return $this->nameEntreprise;
    }

    public function setNameEntreprise(string $nameEntreprise): self
    {
        $this->nameEntreprise = $nameEntreprise;

        return $this;
    }

    /**
     * @return Collection<int, Pfe>
     */
    public function getListePfe(): Collection
    {
        return $this->ListePfe;
    }

    public function addListePfe(Pfe $listePfe): self
    {
        if (!$this->ListePfe->contains($listePfe)) {
            $this->ListePfe[] = $listePfe;
            $listePfe->setEntreprise($this);
        }

        return $this;
    }

    public function removeListePfe(Pfe $listePfe): self
    {
        if ($this->ListePfe->removeElement($listePfe)) {
            // set the owning side to null (unless already changed)
            if ($listePfe->getEntreprise() === $this) {
                $listePfe->setEntreprise(null);
            }
        }

        return $this;
    }
    public function __toString():string{
        return $this->nameEntreprise;
    }
}
