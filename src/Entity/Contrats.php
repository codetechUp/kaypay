<?php

namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\TermesRepository;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ContratsRepository")
 */
class Contrats
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     */
    private $termes;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Partenaire", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $partenaire;

    /**
     * @ORM\Column(type="date")
     */
    private $Date;

   

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTermes(): ?string
    {
        return $this->termes;
    }

    public function setTermes(string $termes): self
    {
        $this->termes = $termes;

        return $this;
    }

    public function getPartenaire(): ?Partenaire
    {
        return $this->partenaire;
    }

    public function setPartenaire(Partenaire $partenaire): self
    {
        $this->partenaire = $partenaire;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->Date;
    }

    public function setDate(\DateTimeInterface $Date): self
    {
        $this->Date = $Date;

        return $this;
       
    }
    public function genContrat($data){
         $contrat = [
            'Registre de Commerce Partenaire' => $data->getPartenaire()->getRc(),
            'Ninea'=> $data->getPartenaire()->getNinea(),
            'Date de Creation' => $data->getDate(),
            "Termes" => $data->getTermes()
        ];
        $response = new JsonResponse($contrat);
        return $response;
    }
}
