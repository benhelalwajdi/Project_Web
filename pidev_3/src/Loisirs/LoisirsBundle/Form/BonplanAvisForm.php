<?php

namespace Loisirs\LoisirsBundle\Form;

use blackknight467\StarRatingBundle\Form\RatingType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


class BonplanAvisForm extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('categorie', TextType::class, [
            'attr' => ['readonly' => true],
        ])
            ->add('region', TextType::class, [
                'attr' => ['readonly' => true],
            ])
            ->add('nom', TextType::class, [
                'attr' => ['readonly' => true],
            ])
            ->add('adresse',TextType::class, [
                'attr' => ['readonly' => true],
            ])
           ->add('description',TextType::class, [
                'attr' => ['readonly' => true],
            ])

            ->add('rating', RatingType::class, [
            'label' => 'Rating'
        ])->add('Accepter',SubmitType::class);
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Loisirs\LoisirsBundle\Entity\Bonplan'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'loisirs_loisirsbundle_bonplan';
    }


}
