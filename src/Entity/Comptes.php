<?php

namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use App\Controller\getAccountPart;
use App\Controller\ImageController;
use App\Controller\CompteController;
use ApiPlatform\Core\Annotation\ApiFilter;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints\Valid;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\MaxDepth;
use Symfony\Component\Validator\Constraints as Assert;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;


/**
 * @ORM\Entity(repositoryClass="App\Repository\ComptesRepository")
 * @ApiResource(
 * normalizationContext={"groups"={"read"}},
 *  denormalizationContext={"groups"={"post"}},
 *  collectionOperations={
 * "get",
 * "get_comptes"={
 * "method":"get",
 * "path":"/comptes/partenaire",
 * "controller":getAccountPart::class},
 *         "post"={
 * "security"="is_granted(['ROLE_ADMIN_SYST','ROLE_ADMIN'])", "security_message"="Seul ADMIN_SYST peut creer un user",
 * "controller"=CompteController::class }
 *     },
 * itemOperations={
 * "put",
 *      "GET"={
 * "security"="is_granted(['ROLE_ADMIN_SYST','ROLE_ADMIN'])"}
 * }  )
 * @ApiFilter(SearchFilter::class, properties={"partenaire.ninea": "exact"})
 */
class Comptes
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
    private $solde;

    /**
     * @ORM\Column(type="integer")
     * @ApiFilter(SearchFilter::class)
     * @Groups({"post","read"})
     */
    private $numero;

    /**
     * @ORM\Column(type="datetime")
     */
    private $creatAt;

    /**
     * @ORM\ManyToOne(cascade="persist",targetEntity="App\Entity\Partenaire", inversedBy="comptes")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\Valid()
     * @Groups({"post","read"})
     */
    private $partenaire;

    /**
     * @ORM\OneToMany(cascade="persist",targetEntity="App\Entity\Depots", mappedBy="compte")
     * @Groups({"post","read"})
     */
    private $depots;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Users", inversedBy="comptes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $userCreator;
    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Affectations", mappedBy="comptes")
     */
    private $affectations;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Transactions", mappedBy="compteEmetteur")
     */
    private $transactions;


    public function __construct()
    {
       
        $this->depots = new ArrayCollection();
        $this->creatAt=  new \DateTime();
        $this->affectations = new ArrayCollection();
        $this->transactions = new ArrayCollection();
       
        
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSolde(): ?int
    {
        return $this->solde;
    }

    public function setSolde(int $solde): self
    {
        $this->solde = $solde;

        return $this;
    }

    public function getNumero(): ?int
    {
        return $this->numero;
    }

    public function setNumero(int $numero): self
    {
        $this->numero = $numero;

        return $this;
    }

    public function getCreatAt(): ?\DateTimeInterface
    {
        return $this->creatAt;
    }

    public function setCreatAt(\DateTimeInterface $creatAt): self
    {
        $this->creatAt = $creatAt;

        return $this;
    }

    public function getPartenaire(): ?Partenaire
    {
        return $this->partenaire;
    }

    public function setPartenaire(?Partenaire $partenaire): self
    {
        $this->partenaire = $partenaire;

        return $this;
    }

    /**
     * @return Collection|Depots[]
     */
    public function getDepots(): Collection
    {
        return $this->depots;
    }

    public function addDepot(Depots $depot): self
    {
        if (!$this->depots->contains($depot)) {
            $this->depots[] = $depot;
            $depot->setCompte($this);
        }

        return $this;
    }

    public function removeDepot(Depots $depot): self
    {
        if ($this->depots->contains($depot)) {
            $this->depots->removeElement($depot);
            // set the owning side to null (unless already changed)
            if ($depot->getCompte() === $this) {
                $depot->setCompte(null);
            }
        }

        return $this;
    }

    public function getUserCreator(): ?Users
    {
        return $this->userCreator;
    }

    public function setUserCreator(?Users $userCreator): self
    {
        $this->userCreator = $userCreator;

        return $this;
    }

    /**
     * @return Collection|Affectations[]
     */
    public function getAffectations(): Collection
    {
        return $this->affectations;
    }

    public function addAffectation(Affectations $affectation): self
    {
        if (!$this->affectations->contains($affectation)) {
            $this->affectations[] = $affectation;
            $affectation->setComptes($this);
        }

        return $this;
    }

    public function removeAffectation(Affectations $affectation): self
    {
        if ($this->affectations->contains($affectation)) {
            $this->affectations->removeElement($affectation);
            // set the owning side to null (unless already changed)
            if ($affectation->getComptes() === $this) {
                $affectation->setComptes(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Transactions[]
     */
    public function getTransactions(): Collection
    {
        return $this->transactions;
    }

    public function addTransaction(Transactions $transaction): self
    {
        if (!$this->transactions->contains($transaction)) {
            $this->transactions[] = $transaction;
            $transaction->setCompteEmetteur($this);
        }

        return $this;
    }

    public function removeTransaction(Transactions $transaction): self
    {
        if ($this->transactions->contains($transaction)) {
            $this->transactions->removeElement($transaction);
            // set the owning side to null (unless already changed)
            if ($transaction->getCompteEmetteur() === $this) {
                $transaction->setCompteEmetteur(null);
            }
        }

        return $this;
    }

   
    
   
}
