<?php

namespace App\Entity;

use App\Repository\OrderRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=OrderRepository::class)
 * @ORM\Table(name="`order`")
 */
class Order
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity=Transaction::class, mappedBy="order")
     */
    private Transaction $transaction;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="orders")
     */
    private User $user;

    /**
     * @ORM\Column(type="smallint", length=6, nullable=false)
     */
    private int $status = 0;

    /**
     * @ORM\Column(type="float", nullable=false)
     */
    private float $subTotal = 0;

    /**
     * @ORM\Column(type="float", nullable=false)
     */
    private float $itemDiscount = 0;

    /**
     * @ORM\Column(type="float", nullable=false)
     */
    private float $tax = 0;

    /**
     * @ORM\Column(type="float", nullable=false)
     */
    private float $shipping = 0;

    /**
     * @ORM\Column(type="float", nullable=false)
     */
    private float $total = 0;

    /**
     * @ORM\Column(type="string", nullable=true, length=50)
     */
    private ?string $promo = null;

    /**
     * @ORM\Column(type="float", nullable=false)
     */
    private float $discount = 0;

    /**
     * @ORM\Column(type="float", nullable=false)
     */
    private float $grandTotal = 0;

    /**
     * @ORM\Column(type="string", nullable=true, length=50)
     */
    private ?string $firstName = null;

    /**
     * @ORM\Column(type="string", nullable=true, length=50)
     */
    private ?string $middleName = null;

    /**
     * @ORM\Column(type="string", nullable=true, length=50)
     */
    private ?string $lastName = null;

    /**
     * @ORM\Column(type="string", nullable=true, length=15)
     */
    private ?string $mobile = null;

    /**
     * @ORM\Column(type="string", nullable=true, length=50)
     */
    private ?string $email = null;

    /**
     * @ORM\Column(type="string", nullable=true, length=50)
     */
    private ?string $line1 = null;

    /**
     * @ORM\Column(type="string", nullable=true, length=50)
     */
    private ?string $line2 = null;

    /**
     * @ORM\Column(type="string", nullable=true, length=50)
     */
    private ?string $city = null;

    /**
     * @ORM\Column(type="string", nullable=true, length=50)
     */
    private ?string $province = null;

    /**
     * @ORM\Column(type="string", nullable=true, length=50)
     */
    private ?string $country = null;

    /**
     * @ORM\Column(type="datetime", nullable=false)
     */
    private \DateTimeInterface $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private ?\DateTimeInterface $updatedAt = null;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private ?string $content = null;

    /**
     * @ORM\OneToMany(targetEntity=OrderItem::class, mappedBy="order")
     */
    private $items;

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
     * @return int
     */
    public function getStatus(): int
    {
        return $this->status;
    }

    /**
     * @param int $status
     */
    public function setStatus(int $status): void
    {
        $this->status = $status;
    }

    /**
     * @return float|int
     */
    public function getSubTotal()
    {
        return $this->subTotal;
    }

    /**
     * @param float|int $subTotal
     */
    public function setSubTotal($subTotal): void
    {
        $this->subTotal = $subTotal;
    }

    /**
     * @return float|int
     */
    public function getItemDiscount()
    {
        return $this->itemDiscount;
    }

    /**
     * @param float|int $itemDiscount
     */
    public function setItemDiscount($itemDiscount): void
    {
        $this->itemDiscount = $itemDiscount;
    }

    /**
     * @return float|int
     */
    public function getTax()
    {
        return $this->tax;
    }

    /**
     * @param float|int $tax
     */
    public function setTax($tax): void
    {
        $this->tax = $tax;
    }

    /**
     * @return float|int
     */
    public function getShipping()
    {
        return $this->shipping;
    }

    /**
     * @param float|int $shipping
     */
    public function setShipping($shipping): void
    {
        $this->shipping = $shipping;
    }

    /**
     * @return float|int
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * @param float|int $total
     */
    public function setTotal($total): void
    {
        $this->total = $total;
    }

    /**
     * @return string|null
     */
    public function getPromo(): ?string
    {
        return $this->promo;
    }

    /**
     * @param string|null $promo
     */
    public function setPromo(?string $promo): void
    {
        $this->promo = $promo;
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
     * @return float|int
     */
    public function getGrandTotal()
    {
        return $this->grandTotal;
    }

    /**
     * @param float|int $grandTotal
     */
    public function setGrandTotal($grandTotal): void
    {
        $this->grandTotal = $grandTotal;
    }

    /**
     * @return string|null
     */
    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    /**
     * @param string|null $firstName
     */
    public function setFirstName(?string $firstName): void
    {
        $this->firstName = $firstName;
    }

    /**
     * @return string|null
     */
    public function getMiddleName(): ?string
    {
        return $this->middleName;
    }

    /**
     * @param string|null $middleName
     */
    public function setMiddleName(?string $middleName): void
    {
        $this->middleName = $middleName;
    }

    /**
     * @return string|null
     */
    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    /**
     * @param string|null $lastName
     */
    public function setLastName(?string $lastName): void
    {
        $this->lastName = $lastName;
    }

    /**
     * @return string|null
     */
    public function getMobile(): ?string
    {
        return $this->mobile;
    }

    /**
     * @param string|null $mobile
     */
    public function setMobile(?string $mobile): void
    {
        $this->mobile = $mobile;
    }

    /**
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param string|null $email
     */
    public function setEmail(?string $email): void
    {
        $this->email = $email;
    }

    /**
     * @return string|null
     */
    public function getLine1(): ?string
    {
        return $this->line1;
    }

    /**
     * @param string|null $line1
     */
    public function setLine1(?string $line1): void
    {
        $this->line1 = $line1;
    }

    /**
     * @return string|null
     */
    public function getLine2(): ?string
    {
        return $this->line2;
    }

    /**
     * @param string|null $line2
     */
    public function setLine2(?string $line2): void
    {
        $this->line2 = $line2;
    }

    /**
     * @return string|null
     */
    public function getCity(): ?string
    {
        return $this->city;
    }

    /**
     * @param string|null $city
     */
    public function setCity(?string $city): void
    {
        $this->city = $city;
    }

    /**
     * @return string|null
     */
    public function getProvince(): ?string
    {
        return $this->province;
    }

    /**
     * @param string|null $province
     */
    public function setProvince(?string $province): void
    {
        $this->province = $province;
    }

    /**
     * @return string|null
     */
    public function getCountry(): ?string
    {
        return $this->country;
    }

    /**
     * @param string|null $country
     */
    public function setCountry(?string $country): void
    {
        $this->country = $country;
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

    public function addOrderItem(OrderItem $orderItem)
    {
        $this->items[] = $orderItem;
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

    public function getItems()
    {
        return $this->items;
    }

}
