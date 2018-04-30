<?php

namespace bsitterBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Abonnement
 *
 * @ORM\Table(name="abonnement", indexes={@ORM\Index(name="id_suiveur", columns={"id_suiveur"}), @ORM\Index(name="id_suivi", columns={"id_suivi"})})
 * @ORM\Entity
 */
class Abonnement
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Column(name="id_abonnement")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $idAbonnement;

    /**
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_suiveur", referencedColumnName="id",onDelete="CASCADE")
     * })
     */
    protected $idSuiveur;

    /**
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_suivi", referencedColumnName="id",onDelete="CASCADE")
     * })
     */
    protected $idSuivi;



    /**
     * Get idAbonnement
     *
     * @return integer
     */
    public function getIdAbonnement()
    {
        return $this->idAbonnement;
    }

    /**
     * Set idSuivi
     *
     * @param \UserBundle\Entity\User $idSuivi
     *
     * @return Abonnement
     */
    public function setIdSuivi(\UserBundle\Entity\User $idSuivi = null)
    {
        $this->idSuivi = $idSuivi;

        return $this;
    }

    /**
     * Get idSuivi
     *
     * @return \UserBundle\Entity\User
     */
    public function getIdSuivi()
    {
        return $this->idSuivi;
    }

    /**
     * Set idSuiveur
     *
     * @param \UserBundle\Entity\User $idSuiveur
     *
     * @return Abonnement
     */
    public function setIdSuiveur(\UserBundle\Entity\User $idSuiveur = null)
    {
        $this->idSuiveur = $idSuiveur;

        return $this;
    }

    /**
     * Get idSuiveur
     *
     * @return \UserBundle\Entity\User
     */
    public function getIdSuiveur()
    {
        return $this->idSuiveur;
    }
}
