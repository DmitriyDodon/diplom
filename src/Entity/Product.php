<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProductRepository::class)
 */
class Product
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="products")
     */
    private User $user;

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
    private ?string $slug;

    /**
     * @ORM\Column(type="string", length=80, nullable=true)
     */
    private ?string $summary = null;

    /**
     * @ORM\Column(type="smallint", length=6, nullable=false)
     */
    private int $type = 0;

    /**
     * @ORM\Column(type="string", length=100, nullable=false)
     */
    private string $sky;

    /**
     * @ORM\Column(type="float", nullable=false)
     */
    private float $price = 0;

    /**
     * @ORM\Column(type="float", nullable=false)
     */
    private float $discount = 0;

    /**
     * @ORM\Column(type="boolean", nullable=false)
     */
    private bool $shop = false;

    /**
     * @ORM\Column(type="datetime", nullable=false)
     */
    private \DateTimeInterface $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private ?\DateTimeInterface $updatedAt = null;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private ?\DateTimeInterface $publishedAt = null;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private ?\DateTimeInterface $startsAt = null;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private ?\DateTimeInterface $endsAt = null;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private ?string $content = null;


    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @param User $user
     */
    public function setUser(User $user): void
    {
        $this->user = $user;
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
     * @return string|null
     */
    public function getSlug(): ?string
    {
        return $this->slug;
    }

    /**
     * @param string|null $slug
     */
    public function setSlug(?string $slug): void
    {
        $this->slug = $slug;
    }

    /**
     * @return string|null
     */
    public function getSummary(): ?string
    {
        return $this->summary;
    }

    /**
     * @param string|null $summary
     */
    public function setSummary(?string $summary): void
    {
        $this->summary = $summary;
    }

    /**
     * @return int
     */
    public function getType(): int
    {
        return $this->type;
    }

    /**
     * @param int $type
     */
    public function setType(int $type): void
    {
        $this->type = $type;
    }

    /**
     * @return string
     */
    public function getSky(): string
    {
        return $this->sky;
    }

    /**
     * @param string $sky
     */
    public function setSky(string $sky): void
    {
        $this->sky = $sky;
    }

    /**
     * @return float|int
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param float|int $price
     */
    public function setPrice($price): void
    {
        $this->price = $price;
    }

    /**
     * @return float|int
     */
    public function getDiscount()
    {
        return $this->discount;
    }

    /**
     * @param float|int $discount
     */
    public function setDiscount($discount): void
    {
        $this->discount = $discount;
    }

    /**
     * @return bool
     */
    public function isShop(): bool
    {
        return $this->shop;
    }

    /**
     * @param bool $shop
     */
    public function setShop(bool $shop): void
    {
        $this->shop = $shop;
    }

    /**
     * @return \DateTimeInterface
     */
    public function getCreatedAt(): \DateTimeInterface
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTimeInterface $createdAt
     */
    public function setCreatedAt(\DateTimeInterface $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    /**
     * @param \DateTimeInterface|null $updatedAt
     */
    public function setUpdatedAt(?\DateTimeInterface $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getPublishedAt(): ?\DateTimeInterface
    {
        return $this->publishedAt;
    }

    /**
     * @param \DateTimeInterface|null $publishedAt
     */
    public function setPublishedAt(?\DateTimeInterface $publishedAt): void
    {
        $this->publishedAt = $publishedAt;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getStartsAt(): ?\DateTimeInterface
    {
        return $this->startsAt;
    }

    /**
     * @param \DateTimeInterface|null $startsAt
     */
    public function setStartsAt(?\DateTimeInterface $startsAt): void
    {
        $this->startsAt = $startsAt;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getEndsAt(): ?\DateTimeInterface
    {
        return $this->endsAt;
    }

    /**
     * @param \DateTimeInterface|null $endsAt
     */
    public function setEndsAt(?\DateTimeInterface $endsAt): void
    {
        $this->endsAt = $endsAt;
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


}
