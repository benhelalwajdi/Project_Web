<?php

namespace Loisirs\LoisirsBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class QuizType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('question',TextareaType::class,array( 'attr' => array('style' => 'width: 300px')))
            ->add('prop1')
            ->add('prop2')
            ->add('prop3')
            ->add('reponse')
            ->add('theme',EntityType::class,array(
                'class'=>'LoisirsLoisirsBundle:Theme',
                'choice_label'=>'nom',
                'multiple'=>false,
            ))
            ->add('Accepter',SubmitType::class);

    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Loisirs\LoisirsBundle\Entity\Quiz'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'loisirs_loisirsbundle_quiz';
    }


}
