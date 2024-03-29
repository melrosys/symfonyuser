<?php

namespace App\Entity;

use App\Entity\Materiel;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\CategoryRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Doctrine\ORM\Mapping\OneToOne;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\JoinColumn;

/**
 * @ApiResource(
 *     normalizationContext={"groups"={"category:read"}},
 *     denormalizationContext={"groups"={"category:write"}}
 * )
 * @ORM\Entity(repositoryClass=CategoryRepository::class)
 */
class Category
{
    /**
     * @ManyToOne(targetEntity="Materiel", fetch="EAGER")
     * @JoinColumn(name="materiel_id", referencedColumnName="id")
     */
    private $materiel;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
	 * @Groups("category:read")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
	 * @Groups({"category:read", "category:write"})
     */
    private $name;

    /**
     * @ORM\Column(type="integer")
	 * @Groups("category:read")
     */
    private $parent;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Groups({"category:read", "category:write"})
     */
    private $data;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Groups({"category:read", "category:write"})
     */
    private $quantity;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     * @Groups({"category:read", "category:write"})
     */
    private $picture;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createAt;

    /**
     * @ORM\Column(type="datetime")
     */
    private $modifiedAt;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getParent(): ?int
    {
        return $this->parent;
    }

    public function setParent(int $parent): self
    {
        $this->parent = $parent;

        return $this;
    }

    public function getData(): ?string
    {
        return $this->data;
    }

    public function setData(string $data): self
    {
        $this->data = $data;

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

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(string $picture): self
    {
        $this->picture = $picture;

        return $this;
    }

    public function getCreateAt(): ?\DateTimeInterface
    {
        return $this->createAt;
    }

    public function setCreateAt(\DateTimeInterface $createAt): self
    {
        $this->createAt = $createAt;

        return $this;
    }

    public function getModifiedAt(): ?\DateTimeInterface
    {
        return $this->modifiedAt;
    }

    public function setModifiedAt(\DateTimeInterface $modifiedAt): self
    {
        $this->modifiedAt = $modifiedAt;

        return $this;
    }

    /**
     * @param Materiel $materiel
     */
    public function setMateriel(Materiel $materiel = null)
    {
        $this->materiel = $materiel;
    }

    /**
     * @return Materiel
     */
    public function getMateriel()
    {
        return $this->materiel;
    }
}
