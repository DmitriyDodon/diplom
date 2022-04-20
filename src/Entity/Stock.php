<?php

namespace App\Entity;

use App\Repository\StockRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=StockRepository::class)
 */
class Stock
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private string $address;

    /**
     * @ORM\OneToMany(targetEntity=ProductStock::class, mappedBy="stock")
     */
    private $products;

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getAddress(): string
    {
        return $this->address;
    }

    /**
     * @param string $address
     */
    public function setAddress(string $address): void
    {
        $this->address = $address;
    }

    public function getProducts(): Collection
    {
        return $this->products;
    }

    public function addProduct(ProductStock $productStock): self
    {
        if (!$this->products->contains($productStock)) {
            $this->products[] = $productStock;
            $productStock->setStock($this);
        }

        return $this;
    }




}
