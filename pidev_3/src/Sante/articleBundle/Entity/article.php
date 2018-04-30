<?php

namespace Sante\articleBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * article
 *
 * @ORM\Table(name="article")
 * @ORM\Entity(repositoryClass="Sante\articleBundle\Repository\articleRepository")
 */
class article
{
    /**
     * @var int
     *
     * @ORM\Column(name="idarticle", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $idarticle;

    /**
     * @var string
     *
     * @ORM\Column(name="Titre", type="string", length=2145)
     */
    private $titre;

    /**
     * @var string
     *
     * @ORM\Column(name="Sujet", type="string", length=2145)
     */
    private $sujet;

    /**
     * @var string
     *
     * @ORM\Column(name="body", type="string", length=2145)
     */
    private $body;


    /**
     * @var string
     *
     * @ORM\Column(name="etat", type="string", length=255)
     */
    private $etat;

    /**
     * @var int
     *
     * @ORM\Column(name="idauteur", type="integer")
     *
     */

    private $idauteur;

    /**
     * @var int
     *
     * @ORM\Column(name="nblike", type="integer")
     *
     */

    private $nblike;

    /**
     * @var string
     *
     * @ORM\Column(name="datepublication", type="string")
     *
     */

    private $datepublication;

    /**
     * @ORM\Column(type="string", nullable=true)
     *
     * @Assert\NotBlank(message="Ajouter une image jpg")
     * @Assert\File(mimeTypes={ "image/jpeg" })
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
     * Set idarticle
     *
     * @param string $idarticle
     *
     * @return article
     */
    public function setIdarticle($idarticle)
    {
        $this->idarticle = $idarticle;

        return $this;
    }

    /**
     * Get idarticle
     *
     * @return int
     */
    public function getIdarticle()
    {
        return $this->idarticle;
    }

    /**
     * Set titre
     *
     * @param string $titre
     *
     * @return article
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
     * Set sujet
     *
     * @param string $sujet
     *
     * @return article
     */
    public function setSujet($sujet)
    {
        $this->sujet = $sujet;

        return $this;
    }

    /**
     * Get sujet
     *
     * @return string
     */
    public function getSujet()
    {
        return $this->sujet;
    }

    /**
     * Set body
     *
     * @param string $body
     *
     * @return article
     */
    public function setBody($body)
    {
        $this->body = $body;

        return $this;
    }

    /**
     * Get body
     *
     * @return string
     */
    public function getBody()
    {
        return $this->body;
    }


    /**
     * Set etat
     *
     * @param string $etat
     *
     * @return article
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
     * Set idauteur
     *
     * @param integer $idauteur
     *
     * @return article
     */
    public function setIdauteur($idauteur)
    {
        $this->idauteur = $idauteur;

        return $this;
    }

    /**
     * Get idauteur
     *
     * @return integer
     */
    public function getIdauteur()
    {
        return $this->idauteur;
    }
    /**
     * Set datepublication
     *
     * @param string $datepublication
     *
     * @return article
     */
    public function setDatepublicaton($datepublication)
    {
        $this->datepublication = $datepublication;

        return $this;
    }

    /**
     * Get datepublication
     *
     * @return string
     */
    public function getDatepublication()
    {
        return $this->datepublication;
    }

    /**
     * @return int
     */
    public function getNblike()
    {
        return $this->nblike;
    }

    /**
     * @param int $nblike
     */
    public function setNblike($nblike)
    {
        $this->nblike = $nblike;
    }

}

