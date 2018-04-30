<?php

namespace Enseignant\EnseignantBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * Book
 *
 * @ORM\Table(name="book")
 * @ORM\Entity(repositoryClass="Enseignant\EnseignantBundle\Repository\BookRepository")
 */
class Book
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
     * @var
     * @ORM\Column(name="nomauteur", type="string",length=220)
     */
private $nomauteur;
    /**
     * @var
     * @ORM\Column(name="description", type="string",length=220)
     */
private $description;
    /**
     * @var
     * @ORM\Column(name="prix", type="integer")
     */
private $prix;
    /**
     * @var
     * @ORM\Column(name="iduser", type="integer")
     */
private $iduser;

    /**
     * @return mixed
     */
    public function getIduser()
    {
        return $this->iduser;
    }

    /**
     * @param mixed $iduser
     */
    public function setIduser($iduser)
    {
        $this->iduser = $iduser;
    }
    /**
     *
     * @ORM\Column( name="nomimage", type="string", length=220,nullable=true)
     */
    public $nomimage;
    /**
     * @Assert\File(maxSize="500k")
     */
    public  $file;

    /**
     * @var
     * @ORM\Column(name="quantite", type="integer")
     */

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
    public function getNomauteur()
    {
        return $this->nomauteur;
    }

    /**
     * @param mixed $nomauteur
     */
    public function setNomauteur($nomauteur)
    {
        $this->nomauteur = $nomauteur;
    }


    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getPrix()
    {
        return $this->prix;
    }

    /**
     * @param mixed $prix
     */
    public function setPrix($prix)
    {
        $this->prix = $prix;
    }
    public function getWebpath()
    {
        return null===$this->nomimage ? null :$this->getUploadDir.'/'.$this->nomimage;
    }
    protected function getUploadRootDir()
    {
        return __DIR__.'/../../../../web/'.$this->getUploadDir();

    }
    protected function getUploadDir()
    {
        return 'images';
    }
    public function uploadProfilePicture()
    {

        $this->file->move($this->getUploadRootDir(), $this->file->getClientOriginalName());
        $this->nomimage=$this->file->getClientOriginalName();
        $this->file=null;
    }

    /**
     * Get nomimage
     * @return string
     */
    public function getNomimage()
    {
        return $this->nomimage;
    }

    /**
     * Set nomimage
     * @param string $nomimage
     * @return categorie
     */
    public function setNomimage($nomimage)
    {
        $this->nomimage == $nomimage;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * @param mixed $file
     */
    public function setFile($file)
    {
        $this->file = $file;
    }


}

