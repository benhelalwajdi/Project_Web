<?php

namespace bsitterBundle\Form ;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vihuvac\Bundle\RecaptchaBundle\Form\Type\VihuvacRecaptchaType;
use Vihuvac\Bundle\RecaptchaBundle\Validator\Constraints\IsTrue as RecaptchaTrue;
use Symfony\Component\Form\FormTypeInterface ;
use bsitterBundle\Entity\besoin;

class besoinType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('descriptionDuBesoin',
                TextareaType::class,
                array( 'attr' => array('style' => 'width: 300px')))
            ->add('modifier',
                SubmitType::class);
    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Besoin::class,
        ));
    }
    public function getName()
    {
        return 'besoin';
    }
}