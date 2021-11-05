<?php

namespace App\Entity;

use App\Entity\User;
use App\Entity\Entites;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\RespStockRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\ORM\Mapping\OneToOne;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\JoinColumn;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=RespStockRepository::class)
 * @UniqueEntity("uniq")
 */
class RespStock
{
    /**
     * @ManyToOne(targetEntity="User", fetch="EAGER")
     * @JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

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
    private $id_entites;

    /**
     * @ORM\Column(type="integer")
     */
    private $id_resp;

    /**
     * @ORM\Column(type="string", length=32)
     */
    private $uniq;

    /**
     * @ORM\Column(type="json", nullable=true)
     */
    private $roles = [];

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

    public function getRoles(): ?array
    {
        return $this->roles;
    }

    public function setRoles(?array $roles): self
    {
        $this->roles = $roles;

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

    /**
     * @param User $user
     */
    public function setUser(User $user = null)
    {
        $this->user = $user;
    }

    /**
     * @return User 
     */
    public function getUser()
    {
        return $this->user;
    }
}
