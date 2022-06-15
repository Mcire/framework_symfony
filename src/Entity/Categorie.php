<?php

namespace App\Entity;

use App\Repository\CategorieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategorieRepository::class)]
class Categorie
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 150)]
    private $nomCategorie;

    #[ORM\OneToMany(mappedBy: 'idCategorie', targetEntity: Produit::class)]
    private $product;

    public function __construct()
    {
        $this->product = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomCategorie(): ?string
    {
        return $this->nomCategorie;
    }

    public function setNomCategorie(string $nomCategorie): self
    {
        $this->nomCategorie = $nomCategorie;

        return $this;
    }

    /**
     * @return Collection<int, Produit>
     */
    public function getProduct(): Collection
    {
        return $this->product;
    }

    public function addProduct(Produit $product): self
    {
        if (!$this->product->contains($product)) {
            $this->product[] = $product;
            $product->setIdCategorie($this);
        }

        return $this;
    }

    public function removeProduct(Produit $product): self
    {
        if ($this->product->removeElement($product)) {
            // set the owning side to null (unless already changed)
            if ($product->getIdCategorie() === $this) {
                $product->setIdCategorie(null);
            }
        }

        return $this;
    }
    public function __toString()
    {
        return $this->nomCategorie;
    }
}
