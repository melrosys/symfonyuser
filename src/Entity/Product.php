<?php

namespace App\Entity;

use App\Entity\Marque;
use App\Entity\SalleStorage;
use App\Repository\ProductRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\OneToOne;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\JoinColumn;

/**
 * @ORM\Entity(repositoryClass=ProductRepository::class)
 */
class Product
{
    /**
     * @ManyToOne(targetEntity="Marque", fetch="EAGER")
     * @JoinColumn(name="marque_id", referencedColumnName="id")
     */
    private $marque;

    /**
     * @ManyToOne(targetEntity="Fournisseur", fetch="EAGER")
     * @JoinColumn(name="fournisseur_id", referencedColumnName="id")
     */
    private $fournisseur;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ManyToOne(targetEntity="SalleStorage", fetch="EAGER")
     * @JoinColumn(name="sallestorage_id", referencedColumnName="id")
     */
    private $sallestorage;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="integer")
     */
    private $id_catego;

    /**
     * @ORM\Column(type="string", length=150)
     */
    private $model;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $picture;

    /**
     * @ORM\Column(type="integer")
     */
    private $id_marque;

    /**
     * @ORM\Column(type="integer")
     */
    private $id_fourni;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $waranty;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $gest_sn;

    /**
     * @ORM\Column(type="integer")
     */
    private $id_materiel;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $tags;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getIdCatego(): ?int
    {
        return $this->id_catego;
    }

    public function setIdCatego(int $id_catego): self
    {
        $this->id_catego = $id_catego;

        return $this;
    }

    public function getModel(): ?string
    {
        return $this->model;
    }

    public function setModel(string $model): self
    {
        $this->model = $model;

        return $this;
    }

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(?string $picture): self
    {
        $this->picture = $picture;

        return $this;
    }

    public function getIdMarque(): ?int
    {
        return $this->id_marque;
    }

    public function setIdMarque(int $id_marque): self
    {
        $this->id_marque= $id_marque;

        return $this;
    }

    public function getIdFourni(): ?int
    {
        return $this->id_fourni;
    }

    public function setIdFourni(int $id_fourni): self
    {
        $this->id_fourni = $id_fourni;

        return $this;
    }

    public function getWaranty(): ?int
    {
        return $this->waranty;
    }

    public function setWaranty(?int $waranty): self
    {
        $this->waranty = $waranty;

        return $this;
    }

    public function getGestSn(): ?int
    {
        return $this->gest_sn;
    }

    public function setGestSn(?int $gest_sn): self
    {
        $this->gest_sn = $gest_sn;

        return $this;
    }

    public function getIdMateriel(): ?int
    {
        return $this->id_materiel;
    }

    public function setIdMateriel(int $id_materiel): self
    {
        $this->id_materiel = $id_materiel;

        return $this;
    }

    public function getTags(): ?string
    {
        return $this->tags;
    }

    public function setTags(?string $tags): self
    {
        $this->tags = $tags;

        return $this;
    }

    /**
     * @param Fournisseur $fournisseur
     */
    public function setFournisseur(Fournisseur $fournisseur = null)
    {
        $this->fournisseur = $fournisseur;
    }

    /**
     * @return Fournisseur
     */
    public function getFournisseur()
    {
        return $this->fournisseur;
    }

    /**
     * @param Marque $marque
     */
    public function setMarque(Marque $marque = null)
    {
        $this->marque = $marque;
    }

    /**
     * @return Marque
     */
    public function getMarque()
    {
        return $this->marque;
    }

    /**
     * @param SalleStorage $salllestorage
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
}
