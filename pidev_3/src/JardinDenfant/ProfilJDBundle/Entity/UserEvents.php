<?php

namespace JardinDenfant\ProfilJDBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UserEvents
 *
 * @ORM\Table(name="user_events")
 * @ORM\Entity(repositoryClass="JardinDenfant\ProfilJDBundle\Repository\UserEventsRepository")
 */
class UserEvents
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
     * Get id
     *
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
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\User", inversedBy="userevents")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="JardinDenfant\ProfilJDBundle\Entity\Evenement", inversedBy="userevents")
     * @ORM\JoinColumn(name="ide", referencedColumnName="ide")
     */
    private $evenement;



    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    /**
     * @return mixed
     */
    public function getEvenement()
    {
        return $this->evenement;
    }

    /**
     * @param mixed $evenement
     */
    public function setEvenement($evenement)
    {
        $this->evenement = $evenement;
    }





}

