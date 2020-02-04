<?php

namespace App\Entity;


use App\Entity\Images;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Controller\UserController;
use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints\Image;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;

/**
 * @ApiResource(
 * collectionOperations={
 *         "get"={
 *          "normalization_context"={"groups"={"get"}},},
 *         "post"={"security"="is_granted(['ROLE_ADMIN_SYST','ROLE_ADMIN','ROLE_PARTENAIRE','ROLE_PADMIN'])", "security_message"="Acces non autorisé",
 * "controller"=UserController::class}
 *     },
 * itemOperations={
 *     "get"={
 *          "normalization_context"={"groups"={"get"}},
 * "security"="is_granted('ROLE_ADMIN_SYST')"},
 *      "put"={"security"="is_granted(['ROLE_ADMIN_SYST','ROLE_ADMIN','ROLE_PARTENAIRE','ROLE_PADMIN'])", "security_message"="Seul ADMIN_SYST peut bloquer un user"}
 * }
 *    
 *     )
 * @ORM\Entity(repositoryClass="App\Repository\UsersRepository")
 * @UniqueEntity("username",message="L'identifiant doit etre Unique")
 * @UniqueEntity("email",message="L'email doit etre Unique")
 */


 //AdvancedUserInterface etend UserInterface c'est pk on a pas besoin d'implentation UserInterface
class Users Implements UserInterface
                                       
                                       {
                                           /**
                                            * @ORM\Id()
                                            * @ORM\GeneratedValue()
                                            * @ORM\Column(type="integer")
                                            */
                                           private $id;
                                       
                                           /**
                                            * @ORM\Column(type="string", length=255)
                                            * @Groups({"get", "post"})
                                            */
                                           private $prenom;
                                       
                                           /**
                                            * @ORM\Column(type="string", length=255)
                                            * @Groups({"get", "post"})
                                            */
                                           private $nom;
                                       
                                           /**
                                            * @ORM\Column(type="string", length=255)
                                            * @Assert\Email(
                                            *     message = "Cet email '{{ value }}' n\'est pas valide."
                                            * )
                                            * @Groups("post")
                                            */
                                           private $email;
                                       
                                           /**
                                            * @ORM\Column(type="string", length=255)
                                            * @Assert\Length(min=8,minMessage="Le mot de passe doit contenir au minimum 8 caracteres")
                                            * @Groups( "post")
                                            */
                                           private $password;
                                       
                                           /**
                                            * @ORM\ManyToOne(targetEntity="App\Entity\Roles", inversedBy="users")
                                            * @ApiSubresource()
                                            */
                                           private $role;
                                           /**
                                            * @ORM\Column(type="boolean")
                                            */
                                           private $isActive;
                                       
                                           /**
                                            * @ORM\Column(type="string", length=255)
                                            * @Groups({"get", "post"})
                                            */
                                           private $username;
                                       
                                       
                                       
                                       
                                           
                                       
                                           /**
                                            * @ORM\ManyToOne(targetEntity="App\Entity\Partenaire", inversedBy="users")
                                            */
                                           private $partenaire;
                                    
                                           /**
                                            * @ORM\OneToMany(targetEntity="App\Entity\Comptes", mappedBy="userCreator")
                                            */
                                           private $comptes;
         
                                           /**
                                            * @ORM\OneToMany(targetEntity="App\Entity\Affectations",fetch="EAGER", mappedBy="users")
                                            */
                                           private $affectations;
                        
                                          
                                           
                                       
                                           public function __construct()
                                           {
                                               $this->isActive=true;
                                               $this->comptes = new ArrayCollection();
                                               $this->affectations = new ArrayCollection();
                                       
                                           }
                                       
                                           public function getId(): ?int
                                           {
                                               return $this->id;
                                           }
                                       
                                           public function getPrenom(): ?string
                                           {
                                               return $this->prenom;
                                           }
                                       
                                           public function setPrenom(string $prenom): self
                                           {
                                               $this->prenom = $prenom;
                                       
                                               return $this;
                                           }
                                       
                                           public function getNom(): ?string
                                           {
                                               return $this->nom;
                                           }
                                       
                                           public function setNom(string $nom): self
                                           {
                                               $this->nom = $nom;
                                       
                                               return $this;
                                           }
                                       
                                           public function getEmail(): ?string
                                           {
                                               return $this->email;
                                           }
                                       
                                           public function setEmail(string $email): self
                                           {
                                               $this->email = $email;
                                       
                                               return $this;
                                           }
                                       
                                           public function getPassword(): ?string
                                           {
                                               return $this->password;
                                           }
                                       
                                           public function setPassword(string $password): self
                                           {
                                               $this->password = $password;
                                       
                                               return $this;
                                           }
                                       
                                           public function getRole(): ?Roles
                                           {
                                               return $this->role;
                                           }
                                       
                                           public function setRole(?Roles $role): self
                                           {
                                               $this->role = $role;
                                       
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
                                           public function eraseCredentials(){
                                       
                                           }
                                           public function getSalt(){
                                       
                                           }
                                           public function getRoles()
                                           {
                                               $roles = $this->role->getLibelle();
                                              return array($roles);
                                              
                                              
                                           }
                                           public function getUsername()
                                           {
                                               return $this->username;
                                           }
                                       
                                           public function setUsername(string $username): self
                                           {
                                               $this->username = $username;
                                       
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
                                            * @return Collection|Comptes[]
                                            */
                                           public function getComptes(): Collection
                                           {
                                               return $this->comptes;
                                           }
                              
                                           public function addCompte(Comptes $compte): self
                                           {
                                               if (!$this->comptes->contains($compte)) {
                                                   $this->comptes[] = $compte;
                                                   $compte->setUserCreator($this);
                                               }
                              
                                               return $this;
                                           }
                           
                                           public function removeCompte(Comptes $compte): self
                                           {
                                               if ($this->comptes->contains($compte)) {
                                                   $this->comptes->removeElement($compte);
                                                   // set the owning side to null (unless already changed)
                                                   if ($compte->getUserCreator() === $this) {
                                                       $compte->setUserCreator(null);
                                                   }
                                               }
                           
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
                                                   $affectation->setUsers($this);
                                               }
   
                                               return $this;
                                           }

                                           public function removeAffectation(Affectations $affectation): self
                                           {
                                               if ($this->affectations->contains($affectation)) {
                                                   $this->affectations->removeElement($affectation);
                                                   // set the owning side to null (unless already changed)
                                                   if ($affectation->getUsers() === $this) {
                                                       $affectation->setUsers(null);
                                                   }
                                               }

                                               return $this;
                                           }
            
                                       
                                           
                                           
                                       }
