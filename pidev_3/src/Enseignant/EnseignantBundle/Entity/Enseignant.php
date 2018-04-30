<?php

namespace Enseignant\EnseignantBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;



/**
 * enseignant
 *
 * @ORM\Table(name="enseignant")
 * @ORM\Entity(repositoryClass="Enseignant\EnseignantBundle\Repository\EnseignantRepository")
 */
class Enseignant
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */

   protected $id;


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
     * @var
     * @ORM\Column(name="nom", type="string",length=220)
     */


    private $nom;
    /**
     * @var
     * @ORM\Column(name="prenom", type="string",length=220)
     */
    private $prenom;

    /**
     * @var
     * @ORM\Column(name="adresse", type="string",length=220)
     */
    private $adresse;
    /**
     * @var
     * @ORM\Column(name="special", type="string",length=220)
     */
    private $special;
    /**
     * @var
     * @ORM\Column(name="prix", type="float")
     */
    private $prix;
    /**
     * @var
     * @ORM\Column(name="numtel", type="integer")
     */
    private $numtel;
    /**
     *
     * @ORM\Column(name="nbr", type="integer" , nullable=true )
     */
private $nbr;
    /**
     * @var
     * @ORM\Column(name="email", type="string",length=220)
     */
private $email;
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

    /**
     * @param mixed $iduser
     */
    public function setIduser($iduser)
    {
        $this->iduser = $iduser;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
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
     * @return mixed
     */
    public function getNbr()
    {
        return $this->nbr;
    }

    /**
     * @param mixed $nbr
     */
    public function setNbr($nbr)
    {
        $this->nbr = $nbr;
    }

    /**
     * @return mixed
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * @param mixed $nom
     */
    public function setNom($nom)
    {
        $this->nom = $nom;
    }

    /**
     * @return mixed
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * @param mixed $prenom
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;
    }


    /**
     * @return mixed
     */
    public function getAdresse()
    {
        return $this->adresse;
    }

    /**
     * @param mixed $adresse
     */
    public function setAdresse($adresse)
    {
        $this->adresse = $adresse;
    }

    /**
     * @return mixed
     */
    public function getSpecial()
    {
        return $this->special;
    }

    /**
     * @param mixed $special
     */
    public function setSpecial($special)
    {
        $this->special = $special;
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
    /**
     * @return mixed
     */
    public function getNumtel()
    {
        return $this->numtel;
    }

    /**
     * @param mixed $numtel
     */
    public function setNumtel($numtel)
    {
        $this->numtel = $numtel;
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



}

