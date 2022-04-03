<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CategoryRepository::class)
 */
class Category
{
    public function __construct()
    {
        $this->products = new ArrayCollection();
    }

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=75, nullable=false)
     */
    private string $title;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private ?string $metaTitle = null;

    /**
     * @ORM\Column(type="string", length=100, nullable=false, unique=true)
     */
    private string $slug;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private ?string $content;

    /**
     * @ORM\ManyToMany(targetEntity=Product::class, inversedBy="catergories", cascade={"persist"})
     * @ORM\JoinTable(
     *     name="product_category",
     *     joinColumns={
     *          @ORM\JoinColumn(name="product_id", referencedColumnName="id")
     *     },
     *     inverseJoinColumns={
     *          @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     *     }
     * )
     */
    private ArrayCollection $products;

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * @return string|null
     */
    public function getMetaTitle(): ?string
    {
        return $this->metaTitle;
    }

    /**
     * @param string|null $metaTitle
     */
    public function setMetaTitle(?string $metaTitle): void
    {
        $this->metaTitle = $metaTitle;
    }

    /**
     * @return string
     */
    public function getSlug(): string
    {
        return $this->slug;
    }

    /**
     * @param string $slug
     */
    public function setSlug(string $slug): void
    {
        $this->slug = $slug;
    }

    /**
     * @return string|null
     */
    public function getContent(): ?string
    {
        return $this->content;
    }

    /**
     * @param string|null $content
     */
    public function setContent(?string $content): void
    {
        $this->content = $content;
    }

    public function addProduct(Product $product): self
    {
        $this->products[] = $product;

        return $this;
    }

    public function removeProduct(Product $product): bool
    {
        return $this->products->removeElement($product);
    }

    public function getProducts(): Collection
    {
        return $this->products;
    }

}
