<?php

namespace Sante\SpecialisteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * MedecinSpecialiste
 *
 * @ORM\Table(name="medecin_specialiste")
 * @ORM\Entity(repositoryClass="Sante\SpecialisteBundle\Repository\MedecinSpecialisteRepository")
 */
class MedecinSpecialiste
{
    /**
     * @var int
     * @ORM\Id
     * @ORM\Column(name="cin", type="integer", unique=true)
     */
    private $cin;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="prenom", type="string", length=255)
     */
    private $prenom;


    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=2000, nullable=true)
     */
    private $description;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateNaissance", type="date")
     */
    private $dateNaissance;

    /**
     * @var string
     *
     * @ORM\Column(name="specialite", type="string", length=255)
     */
    private $specialite;
    /**
     * @var int
     * @ORM\OneToOne(targetEntity="UserBundle\Entity\User", cascade={"persist"})
     * @ORM\Column(name="id", type="integer")
     */
    private $id;
    /**
     * @var int
     *
     * @ORM\Column(name="telephone", type="integer")
     */
    private $telephone;

    /**
     * @var string
     *
     * @ORM\Column(name="numCabinet", type="string", length=255)
     */
    private $numCabinet;

    /**
     * @var string
     *
     * @ORM\Column(name="mail", type="string", length=255)
     */
    private $mail;

    /**
     * @var float
     *
     * @ORM\Column(name="lat", type="float")
     */
    private $lat;

    /**
     * @var float
     *
     * @ORM\Column(name="lng", type="string")
     */
    private $lng;

    /**
     * @var string
     *
     * @ORM\Column(name="municipalite", type="string", length=255)
     */
    private $municipalite;

    /**
     * @var string
     *
     * @ORM\Column(name="gouvernorat", type="string", length=255)
     */
    private $gouvernorat;

    /**
     * @var int
     *
     * @ORM\Column(name="etatverif", type="integer")
     */
    private $etatverif;

    /**
     * @return int
     */
    public function getEtatverif()
    {
        return $this->etatverif;
    }

    /**
     * @param int $etatverif
     */
    public function setEtatverif($etatverif)
    {
        $this->etatverif = $etatverif;
    }

    /**
     * @var int
     *
     * @ORM\Column(name="rating", type="integer")
     */
    private $rating;

    /**
     * @ORM\Column(type="string", nullable=true)
     *
     * @Assert\NotBlank(message="Ajouter une image jpg")
     * @Assert\File(mimeTypes={ "image/jpeg" })
     */
    private $image;

    /**
     * @ORM\Column(type="string")
     *
     * @Assert\NotBlank(message="Please, upload the product brochure as a PDF file.")
     * @Assert\File(mimeTypes={ "application/pdf", "image/jpeg"})
     */
    private $justif;

    /**
     * @return mixed
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param mixed $image
     */
    public function setImage($image)
    {
        $this->image = $image;
    }

    /**
     * @return mixed
     */
    public function getJustif()
    {
        return $this->justif;
    }

    /**
     * @param mixed $pieceJointe
     */
    public function setJustif($justif)
    {
        $this->justif = $justif;
    }

    /**
     * @return mixed
     */
    public function getRating()
    {
        return $this->rating;
    }

    /**
     * @param mixed $rating
     */
    public function setRating($rating)
    {
        $this->rating = $rating;
    }




    /**
     * Set id
     *
     * @param integer $id
     *
     * @return MedecinSpecialiste
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set telephone
     *
     * @param integer $telephone
     *
     * @return MedecinSpecialiste
     */
    public function setTelephone($telephone)
    {
        $this->telephone = $telephone;

        return $this;
    }

    /**
     * Get telephone
     *
     * @return int
     */
    public function getTelephone()
    {
        return $this->telephone;
    }

    /**
     * Set numCabinet
     *
     * @param string $numCabinet
     *
     * @return MedecinSpecialiste
     */
    public function setNumCabinet($numCabinet)
    {
        $this->numCabinet = $numCabinet;

        return $this;
    }

    /**
     * Get numCabinet
     *
     * @return string
     */
    public function getNumCabinet()
    {
        return $this->numCabinet;
    }

    /**
     * Set mail
     *
     * @param string $mail
     *
     * @return MedecinSpecialiste
     */
    public function setMail($mail)
    {
        $this->mail = $mail;

        return $this;
    }

    /**
     * Get mail
     *
     * @return string
     */
    public function getMail()
    {
        return $this->mail;
    }
    /**
     * Set cin
     *
     * @param integer $cin
     *
     * @return MedecinSpecialiste
     */
    public function setCin($cin)
    {
        $this->cin = $cin;

        return $this;
    }

    /**
     * Get cin
     *
     * @return int
     */
    public function getCin()
    {
        return $this->cin;
    }

    /**
     * Set nom
     *
     * @param string $nom
     *
     * @return MedecinSpecialiste
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set prenom
     *
     * @param string $prenom
     *
     * @return MedecinSpecialiste
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;

        return $this;
    }

    /**
     * Get prenom
     *
     * @return string
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return MedecinSpecialiste
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set dateNaissance
     *
     * @param \DateTime $dateNaissance
     *
     * @return MedecinSpecialiste
     */
    public function setDateNaissance($dateNaissance)
    {
        $this->dateNaissance = $dateNaissance;

        return $this;
    }

    /**
     * Get dateNaissance
     *
     * @return \DateTime
     */
    public function getDateNaissance()
    {
        return $this->dateNaissance;
    }

    /**
     * Set specialite
     *
     * @param string $specialite
     *
     * @return MedecinSpecialiste
     */
    public function setSpecialite($specialite)
    {
        $this->specialite = $specialite;

        return $this;
    }

    /**
     * Get specialite
     *
     * @return string
     */
    public function getSpecialite()
    {
        return $this->specialite;
    }

    /**
     * @return float
     */
    public function getLat()
    {
        return $this->lat;
    }

    /**
     * @return float
     */
    public function getLng()
    {
        return $this->lng;
    }

    /**
     * @param float $lat
     */
    public function setLat($lat)
    {
        $this->lat = $lat;
    }

    /**
     * @param float $lng
     */
    public function setLng($lng)
    {
        $this->lng = $lng;
    }



    /**
     * Set municipalite
     *
     * @param string $municipalite
     *
     * @return MedecinSpecialiste
     */
    public function setMunicipalite($municipalite)
    {
        $this->municipalite = $municipalite;

        return $this;
    }

    /**
     * Get municipalite
     *
     * @return string
     */
    public function getMunicipalite()
    {
        return $this->municipalite;
    }

    /**
     * Set gouvernorat
     *
     * @param string $gouvernorat
     *
     * @return MedecinSpecialiste
     */
    public function setGouvernorat($gouvernorat)
    {
        $this->gouvernorat = $gouvernorat;

        return $this;
    }

    /**
     * Get gouvernorat
     *
     * @return string
     */
    public function getGouvernorat()
    {
        return $this->gouvernorat;
    }

    /**
     * Set id
     *
     * @param integer $id
     *
     * @return MedecinSpecialiste
     */
}

