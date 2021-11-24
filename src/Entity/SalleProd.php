<?php

namespace App\Entity;

use App\Entity\SalleStorage;
use App\Entity\Product;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\SalleProdRepository;
use Doctrine\ORM\Mapping as ORM;

use Doctrine\ORM\Mapping\OneToOne;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\JoinColumn;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=SalleProdRepository::class)
 */
class SalleProd
{
    /**
     * @ManyToOne(targetEntity="Product", fetch="EAGER")
     * @JoinColumn(name="product_id", referencedColumnName="id")
     */
    private $product;

    /**
     * @ManyToOne(targetEntity="SalleStorage", fetch="EAGER")
     * @JoinColumn(name="sallestorage_id", referencedColumnName="id")
     */
    private $sallestorage;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $quantity;

    /**
     * @ORM\Column(type="integer")
     */
    private $sallestorage_id;

    /**
     * @ORM\Column(type="integer")
     */
    private $product_id;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $data;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdProduit(): ?int
    {
        return $this->id_produit;
    }

    public function setIdProduit(int $id_produit): self
    {
        $this->id_produit = $id_produit;

        return $this;
    }

    public function getSallestorageId(): ?int
    {
        return $this->sallestorage_id;
    }

    public function setSallestorageId(int $sallestorage_id): self
    {
        $this->sallestorage_id = $sallestorage_id;

        return $this;
    }

    public function getProductId(): ?int
    {
        return $this->product_id;
    }

    public function setProductId(int $product_id): self
    {
        $this->product_id = $product_id;

        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getData(): ?string
    {
        return $this->data;
    }

    public function setData(?string $data): self
    {
        $this->data = $data;

        return $this;
    }

    /**
     * @param SalleStorage $sallestorage
     */
    public function setSalleStorage(SalleStorage $sallestorage = null)
    {
        $this->sallestorage = $sallestorage;
    }

    /**
     * @return SalleStorage
     */
    public function getSalleStorage()
    {
        return $this->sallestorage;
    }

    /**
     * @param Product $product
     */
    public function setProduct(Product $product = null)
    {
        $this->product = $product;
    }

    /**
     * @return Product
     */
    public function getProduct()
    {
        return $this->product;
    }
}
