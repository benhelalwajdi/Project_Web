<?php

namespace BabySitters\BabySittersBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * BabySitter
 *
 * @ORM\Table(name="baby_sitter")
 * @ORM\Entity(repositoryClass="BabySitters\BabySittersBundle\Repository\BabySitterRepository")
 */
class BabySitter
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
     * @ORM\Column(name="adresse", type="string", length=255)
     */
    private $adresse;

    /**
     * @var string
     *
     * @ORM\Column(name="horairedispo", type="string", length=255)
     */
    private $horairedispo;


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
     * Set nom
     *
     * @param string $nom
     *
     * @return BabySitter
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
     * @return BabySitter
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
     * Set adresse
     *
     * @param string $adresse
     *
     * @return BabySitter
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
     * Set horairedispo
     *
     * @param string $horairedispo
     *
     * @return BabySitter
     */
    public function setHorairedispo($horairedispo)
    {
        $this->horairedispo = $horairedispo;

        return $this;
    }

    /**
     * Get horairedispo
     *
     * @return string
     */
    public function getHorairedispo()
    {
        return $this->horairedispo;
    }
}

