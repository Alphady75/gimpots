<?php

namespace App\Entity;

use App\Repository\QuestionnaireRepository;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Traits\Timestamp;

#[ORM\Entity(repositoryClass: QuestionnaireRepository::class)]
#[ORM\HasLifecycleCallbacks]
/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @UniqueEntity(fields={"email"}, message="Il existe déjà un questionnaire avec cette email")
 */
class Questionnaire
{
    use Timestamp;
    
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $sitMatrimoniale;

    #[ORM\Column(type: 'smallint')]
    private $age;

    #[ORM\Column(type: 'smallint')]
    private $nbrEnfantsCharge;

    #[ORM\Column(type: 'string', length: 100)]
    private $sitLogement;

    #[ORM\Column(type: 'string', length: 100)]
    private $activite;

    #[ORM\Column(type: 'integer')]
    private $revNetMensuels;

    #[ORM\Column(type: 'string', length: 60)]
    private $prenom;

    #[ORM\Column(type: 'string', length: 60)]
    private $nom;

    #[ORM\Column(type: 'string', length: 255)]
    private $email;

    #[ORM\Column(type: 'string', length: 60, nullable: true)]
    private $codePostal;

    #[ORM\Column(type: 'string', length: 60, nullable: true)]
    private $telephone;

    #[ORM\Column(type: 'integer')]
    private $securityCode;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSitMatrimoniale(): ?string
    {
        return $this->sitMatrimoniale;
    }

    public function setSitMatrimoniale(string $sitMatrimoniale): self
    {
        $this->sitMatrimoniale = $sitMatrimoniale;

        return $this;
    }

    public function getAge(): ?int
    {
        return $this->age;
    }

    public function setAge(int $age): self
    {
        $this->age = $age;

        return $this;
    }

    public function getNbrEnfantsCharge(): ?int
    {
        return $this->nbrEnfantsCharge;
    }

    public function setNbrEnfantsCharge(int $nbrEnfantsCharge): self
    {
        $this->nbrEnfantsCharge = $nbrEnfantsCharge;

        return $this;
    }

    public function getSitLogement(): ?string
    {
        return $this->sitLogement;
    }

    public function setSitLogement(string $sitLogement): self
    {
        $this->sitLogement = $sitLogement;

        return $this;
    }

    public function getActivite(): ?string
    {
        return $this->activite;
    }

    public function setActivite(string $activite): self
    {
        $this->activite = $activite;

        return $this;
    }

    public function getRevNetMensuels(): ?string
    {
        return $this->revNetMensuels;
    }

    public function setRevNetMensuels(string $revNetMensuels): self
    {
        $this->revNetMensuels = $revNetMensuels;

        return $this;
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

    public function getCodePostal(): ?string
    {
        return $this->codePostal;
    }

    public function setCodePostal(?string $codePostal): self
    {
        $this->codePostal = $codePostal;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(?string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getSecurityCode(): ?int
    {
        return $this->securityCode;
    }

    public function setSecurityCode(int $securityCode): self
    {
        $this->securityCode = $securityCode;

        return $this;
    }
}
