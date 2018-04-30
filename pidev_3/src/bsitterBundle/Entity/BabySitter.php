<?php

namespace bsitterBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\MessageBundle\Model\ParticipantInterface;
use FOS\UserBundle\Model\User as fos ;
use FOS\UserBundle\Model\User;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
/**
 * BabySitter
 * @Vich\Uploadable
 * @ORM\Table(name="babysitter")
 * @ORM\Entity(repositoryClass="bsitterBundle\Repository\BabySitterRepository")
 */
class BabySitter extends fos implements ParticipantInterface
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
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
    /**
     * @var float
     *
     * @ORM\Column(name="salaire", type="float")
     */
    protected $salaire;

    /*
     * @return float
     */
    public function getSalaire(){
        return $this->salaire;
    }

    /*
     * @param float $salaire
     */
    public function setSalaire($salaire){
        $this->salaire = $salaire;
    }

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255, nullable=true)
     */
    protected $nom ;

    /**
     * @var string
     *
     * @ORM\Column(name="prenom", type="string", length=255, nullable=true)
     */
    protected $prenom ;
    /**
     * @var string
     *
     * @ORM\Column(name="ville", type="string", length=255, nullable=true)
     */
    protected $ville ;

    /**
     * @return string
     */
    public function getVille()
    {
        return $this->ville;
    }

    /**
     * @param string $ville
     */
    public function setVille($ville)
    {
        $this->ville = $ville;
    }

    /**
     * @var string
     *
     * @ORM\Column(name="phone", type="string", length=255, nullable=true)
     */
    protected $phone ;

    /**
     * @var float
     *
     * @ORM\Column(name="lat" ,nullable=true)
     */
    protected $lat ;


    /**
     * @var float
     *
     * @ORM\Column(name="lag" ,nullable=true)
     */
    protected $lag ;

    /**
     * @var string
     *
     * @ORM\Column(name="descriptionCv", type="string", length=255, nullable=true)
     */
    protected $descriptionCv;


    /**
     * Set descriptionCv
     *
     * @param string $descriptionCv
     *
     * @return mixed
     */
    public function setDescriptionCv($descriptionCv)
    {
        $this->descriptionCv = $descriptionCv;

        return $this;
    }

    /**
     * Get descriptionCv
     *
     * @return string
     */
    public function getDescriptionCv()
    {
        return $this->descriptionCv;
    }




    /**
     * @return float
     */
    public function getLat()
    {
        return $this->lat;
    }

    /**
     * @param float $lat
     */
    public function setLat($lat)
    {
        $this->lat = $lat;
    }

    /**
     * @return float
     */
    public function getLag()
    {
        return $this->lag;
    }

    /**
     * @param float $lag
     */
    public function setLag($lag)
    {
        $this->lag = $lag;
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
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @param mixed $phone
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
    }

    /**
     * @var string
     *
     * @ORM\Column(name="cv", type="string", length=255, nullable=true)
     */
    protected $cv;

    /**
     * @return string
     */
    public function getCv()
    {
        return $this->cv;
    }

    /**
     * @param string $cv
     */
    public function setCv($cv)
    {
        $this->cv = $cv;
    }


    /**
     * @Vich\UploadableField(mapping="user_cv", fileNameProperty="cv" )
     * @var File
     **@ORM\Column(nullable=true)
     */
    protected $cvFile;


    /**
     * @ORM\Column(type="datetime")
     * @var \DateTime
     */
    protected $cvUpdatedAt;

    /**
     * @return File
     */
    public function getCvFile()
    {
        return $this->cvFile;
    }



    public function setCvFile(File $cv = null)
    {
        $this->cvFile = $cv;

        // VERY IMPORTANT:
        // It is required that at least one field changes if you are using Doctrine,
        // otherwise the event listeners won't be called and the file is lost
        if ($cv) {
            // if 'updatedAt' is not defined in your entity, use another property
            $this->cvUpdatedAt = new \DateTime('now');
        }
    }


    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     *
     * @Vich\UploadableField(mapping="user_image", fileNameProperty="imageName")
     *
     * @var File
     */
    private $imageFile;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @var string
     */
    private $imageName;

    /**
     * @ORM\Column(type="datetime")
     *
     * @var \DateTime
     */


    private $updatedAt;

    /**
     * If manually uploading a file (i.e. not using Symfony Form) ensure an instance
     * of 'UploadedFile' is injected into this setter to trigger the  update. If this
     * bundle's configuration parameter 'inject_on_load' is set to 'true' this setter
     * must be able to accept an instance of 'File' as the bundle will inject one here
     * during Doctrine hydration.
     *
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $image
     *
     * @return BabySitter
     */
    public function setImageFile(File $image = null)
    {
        $this->imageFile = $image;
        $this->updatedAt =  new \DateTime('now');
        if ($image) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTimeImmutable();
        }

        return $this;
    }

    /**
     * @return File|null
     */
    public function getImageFile()
    {
        return $this->imageFile;
    }

    /**
     * @param string $imageName
     *
     * @return BabySitter
     */
    public function setImageName($imageName)
    {
        $this->imageName = $imageName;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getImageName()
    {
        return $this->imageName;
    }


    public function __construct()
    {
        parent::__construct ();
        $this->prenom="";
        $this->nom="";
        $this->phone="";
        $this->descriptionCv="";

    }

}

