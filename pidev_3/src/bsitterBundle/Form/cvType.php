<?php

namespace bsitterBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Vihuvac\Bundle\RecaptchaBundle\Form\Type\VihuvacRecaptchaType;
use Vihuvac\Bundle\RecaptchaBundle\Validator\Constraints\IsTrue as RecaptchaTrue;


class cvType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
         $builder->add("recaptcha", VihuvacRecaptchaType::class,
             array(
                 "attr" => array(
                     "options" => array(
                         "theme" => "light",
                         "type" => "audio",
                         "size" => "normal"
                     )
                 ),
                 "mapped" => false,
                 "constraints" => array(
                     new RecaptchaTrue()
                 )
             )
         )->add('cvFile', FileType::class, array('data_class' => null));
    }

    public function configureOptions(OptionsResolver $resolver)
    {

    }

    public function getName()
    {
        return 'bsitter_bundlecv_form';
    }
}
