<?php

namespace bsitterBundle\Form;

use UserBundle\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vihuvac\Bundle\RecaptchaBundle\Form\Type\VihuvacRecaptchaType;
use Vihuvac\Bundle\RecaptchaBundle\Validator\Constraints\IsTrue as RecaptchaTrue;

class babysitterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
                ->add('salaire')
                ->add('nom')
                ->add('prenom')
                ->add('lat')
                ->add('lag')
                ->add('ville')
                ->add('descriptionCv',
                    TextareaType::class,
                    array( 'attr' => array('style' => 'width: 300px')))
                ->add("recaptcha", VihuvacRecaptchaType::class,
                    array(
                        "attr" => array(
                            "options" => array(
                                "theme" => "light",
                                "type" => "audio",
                                "size" => "normal"
                            )),
                        "mapped" => false,
                        "constraints" => array(
                            new RecaptchaTrue()
                    )))
                ->add('Modifier',
                    SubmitType::class);
    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => User::class,
        ));
    }
    public function getName()
    {
        return 'bs';
    }
}
