<?php

namespace Sante\articleBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * likearticle
 *
 * @ORM\Table(name="likearticle")
 * @ORM\Entity(repositoryClass="Sante\articleBundle\Repository\likearticleRepository")
 */
class likearticle
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
     * @var int
     *
     * @ORM\Column(name="idarticle", type="integer")
     */
    private $idarticle;

    /**
     * @var int
     *
     * @ORM\Column(name="idliker", type="integer")
     */
    private $idliker;

    /**
     * @var int
     *
     * @ORM\Column(name="likeetat", type="integer")
     */
    private $likeetat;


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
     * Set idarticle
     *
     * @param integer $idarticle
     *
     * @return likearticle
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
     * Set idliker
     *
     * @param integer $idliker
     *
     * @return likearticle
     */
    public function setIdliker($idliker)
    {
        $this->idliker = $idliker;

        return $this;
    }

    /**
     * Get idliker
     *
     * @return int
     */
    public function getIdliker()
    {
        return $this->idliker;
    }

    /**
     * Set likeetat
     *
     * @param integer $likeetat
     *
     * @return likearticle
     */
    public function setLikeetat($likeetat)
    {
        $this->likeetat = $likeetat;

        return $this;
    }

    /**
     * Get likeetat
     *
     * @return int
     */
    public function getLikeetat()
    {
        return $this->likeetat;
    }
}

