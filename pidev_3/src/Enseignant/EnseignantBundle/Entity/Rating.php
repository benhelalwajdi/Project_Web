<?php

namespace Enseignant\EnseignantBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Rating
 *
 * @ORM\Table(name="ratingEns")
 * @ORM\Entity(repositoryClass="Enseignant\EnseignantBundle\Repository\RatingRepository")
 */
class Rating
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
     * @var int
     *
     * @ORM\Column(name="rating" ,type="integer")
    */
    private $rating;

    /**
     * @return int
     */
    public function getIdB()
    {
        return $this->idB;
    }

    /**
     * @param int $idB
     */
    public function setIdB($idB)
    {
        $this->idB = $idB;
    }

    /**
     * @var int
     *
     * @ORM\Column(name="idB" ,type="integer")
     */
    private $idB;
}

