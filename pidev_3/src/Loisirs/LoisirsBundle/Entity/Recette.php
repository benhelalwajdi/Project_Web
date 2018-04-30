<?php

namespace Loisirs\LoisirsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * Recette
 *
 * @ORM\Table(name="recette")
 * @ORM\Entity(repositoryClass="Loisirs\LoisirsBundle\Repository\RecetteRepository")
 */
class Recette
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
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * @param string $nom
     */
    public function setNom($nom)
    {
        $this->nom = $nom;
    }

    /**
     * @var string
     *
     * @ORM\Column(name="ingredients", type="string", length=500)
     */
    private $ingredients;
    /**
     * @var int
     *
     * @ORM\Column(name="nbrpersonnes", type="integer")
     */
    private $nbrpersonnes;

    /**
     * @return int
     */
    public function getNbrpersonnes()
    {
        return $this->nbrpersonnes;
    }

    /**
     * @param int $nbrpersonnes
     */
    public function setNbrpersonnes($nbrpersonnes)
    {
        $this->nbrpersonnes = $nbrpersonnes;
    }

    /**
     * @return string
     */
    public function getIngredients()
    {
        return $this->ingredients;
    }

    /**
     * @param string $ingredients
     */
    public function setIngredients($ingredients)
    {
        $this->ingredients = $ingredients;
    }
    /**
     * @ORM\Column(type="string",length=255,nullable=true)
     */
    public $nomVid;
    /**
     * @Assert\File(maxSize="60000k")
     */
    public $file2;

    /**
     * @return mixed
     */
    public function getNomVid()
    {
        return $this->nomVid;
    }

    /**
     * @param mixed $nomVid
     */
    public function setNomVid($nomVid)
    {
        $this->nomVid = $nomVid;
    }

    /**
     * @return mixed
     */
    public function getFile2()
    {
        return $this->file2;
    }

    /**
     * @param mixed $file2
     */
    public function setFile2($file2)
    {
        $this->file2 = $file2;
    }
    public function getWebPath2(){
        return null===$this->nomVid ? null : $this->getUploadDir2.'/'.$this->nomVid;
    }

    protected function getUploadRootDir2(){
        return __DIR__.'/../../../../web/'.$this->getUploadDir2();
    }
    protected function getUploadDir2(){
        return 'uploads/videos';
    }
    public function uploadProfileVideo(){
        var_dump($this->getUploadDir2());
        var_dump($this->getUploadRootDir2());

        //var_dump($this->getClientOriginalName());

        $this->file2->move($this->getUploadRootDir2(), $this->file2->getClientOriginalName());
        $this->nomVid=$this->file2->getClientOriginalName();
        $this->file2=null;
    }


    /**
     * @ORM\Column(type="string",length=255,nullable=true)
     */
    public $nomImage;
    /**
     * @Assert\File(maxSize="60000k")
     */
    public $file;
    public function getWebPath(){
        return null===$this->nomImage ? null : $this->getUploadDir.'/'.$this->nomImage;
    }

    protected function getUploadRootDir(){
        return __DIR__.'/../../../../web/'.$this->getUploadDir();
    }
    protected function getUploadDir(){
        return 'uploads/images';
    }
    public function uploadProfilePicture(){
        var_dump($this->getUploadDir());
        var_dump($this->getUploadRootDir());

        //var_dump($this->getClientOriginalName());

        $this->file->move($this->getUploadRootDir(), $this->file->getClientOriginalName());
        $this->nomImage=$this->file->getClientOriginalName();
        $this->file=null;
    }

    /**
     * @return mixed
     */
    public function getNomImage()
    {
        return $this->nomImage;
    }

    /**
     * @param mixed $nomImage
     */
    public function setNomImage($nomImage)
    {
        $this->nomImage = $nomImage;
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
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
}

