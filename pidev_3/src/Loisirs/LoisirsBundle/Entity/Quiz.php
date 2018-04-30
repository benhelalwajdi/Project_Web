<?php

namespace Loisirs\LoisirsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Quiz
 *
 * @ORM\Table(name="quiz")
 * @ORM\Entity(repositoryClass="Loisirs\LoisirsBundle\Repository\QuizRepository")
 */
class Quiz
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
     * @ORM\Column(name="question", type="string", length=255)
     */
    private $question;

    /**
     * @var int
     *
     * @ORM\Column(name="reponse", type="string",length=255)
     */
    private $reponse;

    /**
     * @var string
     *
     * @ORM\Column(name="prop1", type="string", length=255)
     */
    private $prop1;

    /**
     * @var string
     *
     * @ORM\Column(name="prop2", type="string", length=255)
     */
    private $prop2;
    /**
     * @var string
     *
     * @ORM\Column(name="prop3", type="string", length=255)
     */
    private $prop3;




    /**
     * @ORM\ManyToOne(targetEntity="Theme")
     * @ORM\JoinColumn(name="Theme",referencedColumnName="id",onDelete="CASCADE")
     */
    private $theme;


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
     * @return string
     */
    public function getQuestion()
    {
        return $this->question;
    }

    /**
     * @param string $question
     */
    public function setQuestion($question)
    {
        $this->question = $question;
    }

    /**
     * @return int
     */
    public function getReponse()
    {
        return $this->reponse;
    }

    /**
     * @param int $reponse
     */
    public function setReponse($reponse)
    {
        $this->reponse = $reponse;
    }

    /**
     * @return string
     */
    public function getProp1()
    {
        return $this->prop1;
    }

    /**
     * @param string $prop1
     */
    public function setProp1($prop1)
    {
        $this->prop1 = $prop1;
    }

    /**
     * @return string
     */
    public function getProp2()
    {
        return $this->prop2;
    }

    /**
     * @param string $prop2
     */
    public function setProp2($prop2)
    {
        $this->prop2 = $prop2;
    }

    /**
     * @return string
     */
    public function getProp3()
    {
        return $this->prop3;
    }

    /**
     * @param string $prop3
     */
    public function setProp3($prop3)
    {
        $this->prop3 = $prop3;
    }

    /**
     * @return mixed
     */
    public function getTheme()
    {
        return $this->theme;
    }

    /**
     * @param mixed $theme
     */
    public function setTheme($theme)
    {
        $this->theme = $theme;
    }

}

