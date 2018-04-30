<?php

namespace JardinDenfant\ProfilJDBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * ProfilJD
 *
 * @ORM\Table(name="profil_j_d")
 * @ORM\Entity(repositoryClass="JardinDenfant\ProfilJDBundle\Repository\ProfilJDRepository")
 */
class ProfilJD
{

    /**
     * @var int
     * @ORM\Id
     * @ORM\Column(name="numauth", type="integer", unique=true)
     */
    private $numauth;

    /**
     * @return int
     */
    public function getNumauth()
    {
        return $this->numauth;
    }

    /**
     * @param int $numauth
     */
    public function setNumauth($numauth)
    {
        $this->numauth = $numauth;
    }




    /**
     * @var string
     *
     * @ORM\Column(name="nomJD", type="string", length=255)
     */
    private $nomJD;

    /**
     * @ORM\Column(type="string")
     *
     * @Assert\NotBlank(message="Ajouter une image jpg")
     * @Assert\File(mimeTypes={ "image/jpeg" })
     */
    private $image;

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
     * @var string
     *
     * @ORM\Column(name="adresse", type="string", length=255)
     */
    private $adresse;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=2000)
     */
    private $description;

    /**
     * @var int
     *
     * @ORM\Column(name="num", type="integer")
     */
    private $num;

    /**
     * Set nomJD
     *
     * @param string $nomJD
     *
     * @return ProfilJD
     */
    public function setNomJD($nomJD)
    {
        $this->nomJD = $nomJD;

        return $this;
    }

    /**
     * Get nomJD
     *
     * @return string
     */
    public function getNomJD()
    {
        return $this->nomJD;
    }

    /**
     * Set adresse
     *
     * @param string $adresse
     *
     * @return ProfilJD
     */
    public function setAdresse($adresse)
    {
        $this->adresse = $adresse;

        return $this;
    }

    /**
     * Get adresse
     *
     * @return string
     */
    public function getAdresse()
    {
        return $this->adresse;
    }

    /**
     * Set num
     *
     * @param integer $num
     *
     * @return ProfilJD
     */
    public function setNum($num)
    {
        $this->num = $num;

        return $this;
    }

    /**
     * Get num
     *
     * @return int
     */
    public function getNum()
    {
        return $this->num;
    }



    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }
    /**
     * @var int
     * @ORM\OneToOne(targetEntity="UserBundle\Entity\User", cascade={"persist"})
     * @ORM\Column(name="id", type="integer")
     */
    private $id;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }


    /**
     * @var float
     *
     * @ORM\Column(name="longitude", type="float", length=255)
     */
    private $longitude;

    /**
     * @var float
     *
     * @ORM\Column(name="latitude", type="float", length=255)
     */
    private $latitude;

    /**
     * @return float
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * @param float $longitude
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;
    }

    /**
     * @return float
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * @param float $latitude
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;
    }



    /**
     * @var boolean
     *
     * @ORM\Column(name="valide", type="boolean")
     */
    private $valide;

    /**
     * @return bool
     */
    public function isValide()
    {
        return $this->valide;
    }

    /**
     * @param bool $valide
     */
    public function setValide($valide)
    {
        $this->valide = $valide;
    }

    /**
     * @var int
     *
     * @ORM\Column(name="rating", type="integer")
     */
    private $rating;

    /**
     * @return int
     */
    public function getRating()
    {
        return $this->rating;
    }

    /**
     * @param int $rating
     */
    public function setRating($rating)
    {
        $this->rating = $rating;
    }






}
