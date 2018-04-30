<?php

namespace Sante\articleBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * notifarticle
 *
 * @ORM\Table(name="notifarticle")
 * @ORM\Entity(repositoryClass="Sante\articleBundle\Repository\notifarticleRepository")
 */
class notifarticle
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="titre", type="string", length=255)
     */
    private $titre;

    /**
     * @var string
     *
     * @ORM\Column(name="etat", type="string", length=255)
     */
    private $etat;

    /**
     * @var int
     *
     * @ORM\Column(name="etatnotif", type="integer")
     */
    private $etatnotif;

    /**
     * @var int
     *
     * @ORM\Column(name="idmedecin", type="integer")
     */
    private $idmedecin;

    /**
     * @return int
     */
    public function getIdmedecin()
    {
        return $this->idmedecin;
    }

    /**
     * @param int $idmedecin
     */
    public function setIdmedecin($idmedecin)
    {
        $this->idmedecin = $idmedecin;
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
     * Set titre
     *
     * @param string $titre
     *
     * @return notifarticle
     */
    public function setTitre($titre)
    {
        $this->titre = $titre;

        return $this;
    }

    /**
     * Get titre
     *
     * @return string
     */
    public function getTitre()
    {
        return $this->titre;
    }

    /**
     * Set etat
     *
     * @param string $etat
     *
     * @return notifarticle
     */
    public function setEtat($etat)
    {
        $this->etat = $etat;

        return $this;
    }

    /**
     * Get etat
     *
     * @return string
     */
    public function getEtat()
    {
        return $this->etat;
    }

    /**
     * Set etatnotif
     *
     * @param integer $etatnotif
     *
     * @return notifarticle
     */
    public function setEtatnotif($etatnotif)
    {
        $this->etatnotif = $etatnotif;

        return $this;
    }

    /**
     * Get etatnotif
     *
     * @return int
     */
    public function getEtatnotif()
    {
        return $this->etatnotif;
    }
}

