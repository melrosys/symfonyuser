<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\EntitesRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=EntitesRepository::class)
 */
class Entites
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
    private $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $adresse;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $ville;

    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     */
    private $codep;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $name_resp_stock;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $email_resp_stock;

    /**
     * @ORM\Column(type="string", length=20, nullable=true)
     */
    private $tel_resp_stock;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $picture;

    /**
     * @ORM\Column(type="string", length=20, nullable=true)
     */
    private $tel_entite;

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

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(?string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(?string $ville): self
    {
        $this->ville = $ville;

        return $this;
    }

    public function getCodep(): ?string
    {
        return $this->codep;
    }

    public function setCodep(?string $codep): self
    {
        $this->codep = $codep;

        return $this;
    }

    public function getNameRespStock(): ?string
    {
        return $this->name_resp_stock;
    }

    public function setNameRespStock(?string $name_resp_stock): self
    {
        $this->name_resp_stock = $name_resp_stock;

        return $this;
    }

    public function getEmailRespStock(): ?string
    {
        return $this->email_resp_stock;
    }

    public function setEmailRespStock(?string $email_resp_stock): self
    {
        $this->email_resp_stock = $email_resp_stock;

        return $this;
    }

    public function getTelRespStock(): ?string
    {
        return $this->tel_resp_stock;
    }

    public function setTelRespStock(string $tel_resp_stock): self
    {
        $this->tel_resp_stock = $tel_resp_stock;

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

    public function getTelEntite(): ?string
    {
        return $this->tel_entite;
    }

    public function setTelEntite(?string $tel_entite): self
    {
        $this->tel_entite = $tel_entite;

        return $this;
    }
}
