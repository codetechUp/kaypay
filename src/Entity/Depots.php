<?php

namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use App\Controller\DepotController;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DepotsRepository")
 * @ApiResource(
 * * collectionOperations={
 *         "post"={"security"="is_granted(['ROLE_ADMIN_SYST','ROLE_ADMIN','ROLE_CAISSIER'])", "security_message"="Seul ADMIN_SYST peut creer un user",
 * "controller"=DepotController::class}
 *     }
 * )
 */
class Depots
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"post","read"})
     */
    private $montant;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"post","read"})
     */
    private $dateDepot;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Comptes", inversedBy="depots")
     * @ORM\JoinColumn(nullable=false)
     */
    private $compte;
    public function __construct()
    {
        $this->dateDepot=  new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMontant(): ?int
    {
        return $this->montant;
    }

    public function setMontant(int $montant): self
    {
        $this->montant = $montant;

        return $this;
    }

    public function getDateDepot(): ?\DateTimeInterface
    {
        return $this->dateDepot;
    }

    public function setDateDepot(\DateTimeInterface $dateDepot): self
    {
        $this->dateDepot = $dateDepot;

        return $this;
    }

    public function getCompte(): ?Comptes
    {
        return $this->compte;
    }

    public function setCompte(?Comptes $compte): self
    {
        $this->compte = $compte;

        return $this;
    }
}
