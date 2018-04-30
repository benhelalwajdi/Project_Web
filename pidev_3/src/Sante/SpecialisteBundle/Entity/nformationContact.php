<?php

namespace Sante\SpecialisteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * nformationContact
 *
 * @ORM\Table(name="nformation_contact")
 * @ORM\Entity(repositoryClass="Sante\SpecialisteBundle\Repository\nformationContactRepository")
 */
class nformationContact
{

    /**
     * @var int
     *
     * @ORM\Column(name="idinformation", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $idinformation;

    /**
     * @var int
     *
     * @ORM\Column(name="id")
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
     * Get idinformation
     *
     * @return int
     */
    public function getIdinformation()
    {
        return $this->idinformation;
    }

    /**
     * Set id
     *
     * @param integer $id
     *
     * @return nformationContact
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
     * @return nformationContact
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
     * @return nformationContact
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
     * @return nformationContact
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
}

