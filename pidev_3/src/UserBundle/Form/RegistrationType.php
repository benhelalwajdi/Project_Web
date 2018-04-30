<?php

namespace FOSUserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('roles',ChoiceType::class,array('choices'=>array('ROLE_PARENT'=>'ROLE_PARENT','ROLE_MEDECIN'=>'ROLE_MEDECIN','ROLE_VENDEUR'=>'ROLE_VENDEUR','ROLE_JARDIN_ENFANT'=>'ROLE_JARDIN_ENFANT','ROLE_ENSEIGNANT'=>'ROLE_ENSEIGNANT','ROLE_BABY_SITTER'=>'ROLE_BABY_SITTER')));
    }

    public function configureOptions(OptionsResolver $resolver)
    {

    }
    public function getParent()
    {
        return 'FOS\UserBundle\Form\Type\RegistrationFormType';
    }
    public function getName()
    {
        return 'forum_bundle_registration_type';
    }
}
