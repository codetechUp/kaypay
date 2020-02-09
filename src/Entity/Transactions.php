<?php
namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use App\Controller\RetraitController;
use App\Controller\TransactionController;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Validator\Constraints\Date;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TransactionsRepository")
 * @ApiResource(
 * collectionOperations={
 * "get",
 *         "post"={"security"="is_granted(['ROLE_PARTENAIRE','ROLE_PADMIN','ROLE_PUSER'])", "security_message"="Acces non autorisé",
 * "controller"=TransactionController::class}
 *     },
 *  itemOperations={
 *      "get",
 *      "put"={
 * "security"="is_granted(['ROLE_PARTENAIRE','ROLE_PADMIN','ROLE_PUSER'])", "security_message"="Acces non autorisé",
 * "controller"=RetraitController::class}
 * }
 * )
 */
class Transactions
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nomClientEmetteur;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $prenomClientEmetteur;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $TelClientEmetteur;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $ncClientEmet;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nomClRecept;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $prenomCliRecepteur;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $telCliRecept;

    /**
     * @ORM\Column(type="string", length=255, nullable=true )
     */
    private $ncCliRecep;

    /**
     * @ORM\Column(type="date")
     */
    private $dateEnvoi;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $dateRetrait;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Users", inversedBy="transactions")
     * @ORM\JoinColumn(nullable=false)
     */
    private $userEmetteur;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Comptes", inversedBy="transactions")
     * @ORM\JoinColumn(nullable=false)
     */
    private $compteEmetteur;
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Users", inversedBy="transactions")
     */
    private $userRecep;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Comptes", inversedBy="transactions")
     */
    private $compteRecept;

    /**
     * @ORM\Column(type="integer")
     */
    private $code;

    /**
     * @ORM\Column(type="integer")
     */
    private $montant;

    /**
     * @ORM\Column(type="integer")
     */
    private $partEtat;

    /**
     * @ORM\Column(type="integer")
     */
    private $partAgence;

    /**
     * @ORM\Column(type="integer")
     */
    private $partPdepot;

    /**
     * @ORM\Column(type="integer")
     */
    private $pRetrait;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isActive;

   
    public function __construct()
    {
       
        $this->dateEnvoi=new DateTime();
        $this->isActive=true;
       
        
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomClientEmetteur(): ?string
    {
        return $this->nomClientEmetteur;
    }

    public function setNomClientEmetteur(string $nomClientEmetteur): self
    {
        $this->nomClientEmetteur = $nomClientEmetteur;

        return $this;
    }

    public function getPrenomClientEmetteur(): ?string
    {
        return $this->prenomClientEmetteur;
    }

    public function setPrenomClientEmetteur(string $prenomClientEmetteur): self
    {
        $this->prenomClientEmetteur = $prenomClientEmetteur;

        return $this;
    }

    public function getTelClientEmetteur(): ?string
    {
        return $this->TelClientEmetteur;
    }

    public function setTelClientEmetteur(string $TelClientEmetteur): self
    {
        $this->TelClientEmetteur = $TelClientEmetteur;

        return $this;
    }

    public function getNcClientEmet(): ?string
    {
        return $this->ncClientEmet;
    }

    public function setNcClientEmet(string $ncClientEmet): self
    {
        $this->ncClientEmet = $ncClientEmet;

        return $this;
    }

    public function getNomClRecept(): ?string
    {
        return $this->nomClRecept;
    }

    public function setNomClRecept(string $nomClRecept): self
    {
        $this->nomClRecept = $nomClRecept;

        return $this;
    }

    public function getPrenomCliRecepteur(): ?string
    {
        return $this->prenomCliRecepteur;
    }

    public function setPrenomCliRecepteur(string $prenomCliRecepteur): self
    {
        $this->prenomCliRecepteur = $prenomCliRecepteur;

        return $this;
    }

    public function getTelCliRecept(): ?string
    {
        return $this->telCliRecept;
    }

    public function setTelCliRecept(string $telCliRecept): self
    {
        $this->telCliRecept = $telCliRecept;

        return $this;
    }

    public function getNcCliRecep(): ?string
    {
        return $this->ncCliRecep;
    }

    public function setNcCliRecep(string $ncCliRecep): self
    {
        $this->ncCliRecep = $ncCliRecep;

        return $this;
    }

    public function getDateEnvoi(): ?\DateTimeInterface
    {
        return $this->dateEnvoi;
    }

    public function setDateEnvoi(\DateTimeInterface $dateEnvoi): self
    {
        $this->dateEnvoi = $dateEnvoi;

        return $this;
    }

    public function getDateRetrait(): ?\DateTimeInterface
    {
        return $this->dateRetrait;
    }

    public function setDateRetrait(?\DateTimeInterface $dateRetrait): self
    {
        $this->dateRetrait = $dateRetrait;

        return $this;
    }

    public function getUserEmetteur(): ?Users
    {
        return $this->userEmetteur;
    }

    public function setUserEmetteur(?Users $userEmetteur): self
    {
        $this->userEmetteur = $userEmetteur;

        return $this;
    }

    public function getCompteEmetteur(): ?Comptes
    {
        return $this->compteEmetteur;
    }

    public function setCompteEmetteur(?Comptes $compteEmetteur): self
    {
        $this->compteEmetteur = $compteEmetteur;

        return $this;
    }

    public function getUserRecep(): ?Users
    {
        return $this->userRecep;
    }

    public function setUserRecep(?Users $userRecep): self
    {
        $this->userRecep = $userRecep;

        return $this;
    }

    public function getCompteRecept(): ?Comptes
    {
        return $this->compteRecept;
    }

    public function setCompteRecept(?Comptes $compteRecept): self
    {
        $this->compteRecept = $compteRecept;

        return $this;
    }

    public function getCode(): ?int
    {
        return $this->code;
    }

    public function setCode(int $code): self
    {
        $this->code = $code;

        return $this;
    }
    public function genCode(){
        return strval(rand(100,1234598760));
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

    public function getPartEtat(): ?int
    {
        return $this->partEtat;
    }

    public function setPartEtat(int $partEtat): self
    {
        $this->partEtat = $partEtat;

        return $this;
    }

    public function getPartAgence(): ?int
    {
        return $this->partAgence;
    }

    public function setPartAgence(int $partAgence): self
    {
        $this->partAgence = $partAgence;

        return $this;
    }

    public function getPartPdepot(): ?int
    {
        return $this->partPdepot;
    }

    public function setPartPdepot(int $partPdepot): self
    {
        $this->partPdepot = $partPdepot;

        return $this;
    }

    public function getPRetrait(): ?int
    {
        return $this->pRetrait;
    }

    public function setPRetrait(int $pRetrait): self
    {
        $this->pRetrait = $pRetrait;

        return $this;
    }

    public function getIsActive(): ?bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): self
    {
        $this->isActive = $isActive;

        return $this;
    }

   
}
