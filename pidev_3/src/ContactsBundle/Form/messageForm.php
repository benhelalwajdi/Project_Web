<?php

namespace ContactsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class messageForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
$builder->add('body')->add('submit',SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {

    }

    public function getName()
    {
        return 'contacts_bundlemessage_form';
    }
}
