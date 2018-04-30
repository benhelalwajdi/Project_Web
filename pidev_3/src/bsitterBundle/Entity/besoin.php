<?php

namespace bsitterBundle\Entity;


use Doctrine\ORM\Mapping as ORM;
/**
 * besoin
 *
 * @ORM\Table(name="besoin")
 * @ORM\Entity(repositoryClass="bsitterBundle\Repository\BesoinRepository")
 */
class besoin {

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var \DateTime
     * @ORM\Column(name="createAt", type="datetime")
     *
     */
    protected $createAt;

    /**
     * @return \DateTime
     */
    public function getCreateAt()
    {
        return $this->createAt;
    }

    /**
     * @param \DateTime $createAt
     */
    public function setCreateAt($createAt)
    {
        $this->createAt = $createAt;
    }


    /**
     * @var String
     *
     * @ORM\Column(name="descriptionBesoin", type="string", length=255, nullable=true)
     */
    protected  $descriptionDuBesoin ;

    /**
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idbs", referencedColumnName="id",onDelete="CASCADE")
     * })
     */
    protected $idbs;

    /**
     * @return String
     */
    public function getDescriptionDuBesoin()
    {
        return $this->descriptionDuBesoin;
    }

    /**
     * @param String $descriptionDuBesoin
     */
    public function setDescriptionDuBesoin($descriptionDuBesoin)
    {
        $this->descriptionDuBesoin = $descriptionDuBesoin;
    }


    /**
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idp", referencedColumnName="id",onDelete="CASCADE")
     * })
     */
    protected $idp;

    /**
     * @return mixed
     */
    public function getIdbs()
    {
        return $this->idbs;
    }

    /**
     * @param mixed $idbs
     */
    public function setIdbs($idbs)
    {
        $this->idbs = $idbs;
    }


    /**
     * @return mixed
     */
    public function getIdp()
    {
        return $this->idp;
    }

    /**
     * @param mixed $idp
     */
    public function setIdp($idp)
    {
        $this->idp = $idp;
    }



    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

}