<?php

namespace App\Entity;

use App\Entity\Entites;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\SalleStorageRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\OneToOne;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\JoinColumn;

/**
 * @ORM\Entity(repositoryClass=SalleStorageRepository::class)
 */
class SalleStorage
{
    /**
     * @ManyToOne(targetEntity="Entites", fetch="EAGER")
     * @JoinColumn(name="entites_id", referencedColumnName="id")
     */
    private $entites;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $site_id;

    /**
     * @ORM\Column(type="string", length=150)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $position;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $data;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSiteId(): ?int
    {
        return $this->site_id;
    }

    public function setSiteId(int $site_id): self
    {
        $this->site_id = $site_id;

        return $this;
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

    public function getPosition(): ?string
    {
        return $this->position;
    }

    public function setPosition(?string $position): self
    {
        $this->position = $position;

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
     * @param Entites $entites
     */
    public function setEntites(Entites $entites = null)
    {
        $this->entites = $entites;
    }

    /**
     * @return Entites
     */
    public function getEntites()
    {
        return $this->entites;
    }
}
