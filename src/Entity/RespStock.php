<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\RespStockRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=RespStockRepository::class)
 */
class RespStock
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $id_entites;

    /**
     * @ORM\Column(type="integer")
     */
    private $id_resp;

    /**
     * @ORM\Column(type="string", length=32)
     */
    private $uniq;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdEntites(): ?int
    {
        return $this->id_entites;
    }

    public function setIdEntites(int $id_entites): self
    {
        $this->id_entites = $id_entites;

        return $this;
    }

    public function getIdResp(): ?int
    {
        return $this->id_resp;
    }

    public function setIdResp(int $id_resp): self
    {
        $this->id_resp = $id_resp;

        return $this;
    }

    public function getUniq(): ?string
    {
        return $this->uniq;
    }

    public function setUniq(string $uniq): self
    {
        $this->uniq = $uniq;

        return $this;
    }
}
