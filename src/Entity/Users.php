<?php

namespace App\Entity;


use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;

/**
 * @ApiResource(
 * collectionOperations={
 *         "get"={
 *          "normalization_context"={"groups"={"get"}},},
 *         "post"={"security"="is_granted('ROLE_ADMIN_SYST')", "security_message"="Seul ADMIN_SYST peut creer un user"}
 *     },
 * itemOperations={
 *     "get"={
 *          "normalization_context"={"groups"={"get"}},},
 *      "put"={"security"="is_granted('ROLE_ADMIN_SYST')", "security_message"="Seul ADMIN_SYST peut bloquer un user"}
 * }
 *    
 *     )
 * @ORM\Entity(repositoryClass="App\Repository\UsersRepository")
 * @UniqueEntity("username",message="L'identifiant doit etre Unique")
 * @UniqueEntity("email",message="L'email doit etre Unique")
 */


 //AdvancedUserInterface etend UserInterface c'est pk on a pas besoin d'implentation UserInterface
class Users Implements AdvancedUserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("get")
     */
    private $prenom;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("get")
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(min=8,minMessage="Le mot de passe doit contenir au minimum 8 caracteres")
     */
    private $password;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Roles", inversedBy="users")
     */
    private $role;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isActive;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("get")
     */
    private $username;
    public function __construct()
    {;
        $this->isActive=true;

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
        $roles[] = $this->role->getLibelle();
       return array_unique($roles);
       
       
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
    // les fonction abstraites AdvancedUserInterface
    public function isAccountNonExpired()
    {
        return true;
    }

    public function isAccountNonLocked()
    {
        return true;
    }

    public function isCredentialsNonExpired()
    {
        return true;
    }
    public function isEnabled()
    {
        return $this->isActive;
    }
}
