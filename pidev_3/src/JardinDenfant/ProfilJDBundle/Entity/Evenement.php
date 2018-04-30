<?php

namespace JardinDenfant\ProfilJDBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Validator\Constraints as Assert;
/**
 * Evenement
 *
 * @ORM\Table(name="evenement")
 * @ORM\Entity(repositoryClass="JardinDenfant\ProfilJDBundle\Repository\EvenementRepository")
 */
class Evenement
{
    /**
     * @var int
     *
     * @ORM\Column(name="ide", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $ide;

    /**
     * @var string
     *
     * @ORM\Column(name="nonE", type="string", length=255)
     */
    private $nonE;

    /**
     * @var string
     *
     * @ORM\Column(name="apropos", type="string", length=255)
     */
    private $apropos;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="start", type="date")
     */
    private $start;

    /**
     * @var string
     *
     * @ORM\Column(name="heure", type="string", length=255)
     */
    private $heure;

    /**
     * @var string
     *
     * @ORM\Column(name="duree", type="string", length=255)
     */
    private $duree;

    /**
     * @var string
     *
     * @ORM\Column(name="adresse", type="string", length=255)
     */
    private $adresse;

    /**
     * @var int
     *
     * @ORM\Column(name="nbrPlaceMax", type="integer")
     */
    private $nbrPlaceMax;

    /**
     * @ORM\ManyToOne(targetEntity="ProfilJD")
     * @ORM\Column(name="numauth", type="integer")
     */
    private $numauth;








    /**
     * Set nonE
     *
     * @param string $nonE
     *
     * @return Evenement
     */
    public function setNonE($nonE)
    {
        $this->nonE = $nonE;

        return $this;
    }

    /**
     * Get nonE
     *
     * @return string
     */
    public function getNonE()
    {
        return $this->nonE;
    }

    /**
     * Set apropos
     *
     * @param string $apropos
     *
     * @return Evenement
     */
    public function setApropos($apropos)
    {
        $this->apropos = $apropos;

        return $this;
    }

    /**
     * Get apropos
     *
     * @return string
     */
    public function getApropos()
    {
        return $this->apropos;
    }


    /**
     * Set heure
     *
     * @param string $heure
     *
     * @return Evenement
     */
    public function setHeure($heure)
    {
        $this->heure = $heure;

        return $this;
    }

    /**
     * Get heure
     *
     * @return string
     */
    public function getHeure()
    {
        return $this->heure;
    }

    /**
     * Set duree
     *
     * @param string $duree
     *
     * @return Evenement
     */
    public function setDuree($duree)
    {
        $this->duree = $duree;

        return $this;
    }

    /**
     * Get duree
     *
     * @return string
     */
    public function getDuree()
    {
        return $this->duree;
    }

    /**
     * Set adresse
     *
     * @param string $adresse
     *
     * @return Evenement
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
     * Set nbrPlaceMax
     *
     * @param integer $nbrPlaceMax
     *
     * @return Evenement
     */
    public function setNbrPlaceMax($nbrPlaceMax)
    {
        $this->nbrPlaceMax = $nbrPlaceMax;

        return $this;
    }

    /**
     * Get nbrPlaceMax
     *
     * @return int
     */
    public function getNbrPlaceMax()
    {
        return $this->nbrPlaceMax;
    }

    /**
     * @return int
     */
    public function getIde()
    {
        return $this->ide;
    }

    /**
     * @param int $ide
     */
    public function setIde($ide)
    {
        $this->ide = $ide;
    }

    /**
     * @return mixed
     */
    public function getNumauth()
    {
        return $this->numauth;
    }

    /**
     * @param mixed $numauth
     */
    public function setNumauth($numauth)
    {
        $this->numauth = $numauth;
    }








    /**
     * @return \DateTime
     * @return \DateTime
     */
    public function getStart()
    {
        return $this->start;
    }

    /**
     * @param \DateTime $start
     */
    public function setStart($start)
    {
        $this->start = $start;
    }



    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return \DateTime
     */
    public function getStartDate()
    {
        return $this->startDate;
    }

    /**
     * @param \DateTime $startDate
     */
    public function setStartDate($startDate)
    {
        $this->startDate = $startDate;
    }

    /**
     * @var string
     *
     * @ORM\Column(name="image", type="string", length=2000 ,nullable=true)
     */
    private $image;

    public function getImage()
    {
        return $this->image;
    }

    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }




    /**
     * @ORM\OneToMany(targetEntity="JardinDenfant\ProfilJDBundle\Entity\UserEvents", mappedBy="Evenement", cascade={"persist", "remove"})
     */
    private $userevents;

    /**
     * @return mixed
     */
    public function getUserevents()
    {
        return $this->userevents;
    }

    /**
     * @param mixed $userevents
     */
    public function setUserevents($userevents)
    {
        $this->userevents = $userevents;
    }


}

