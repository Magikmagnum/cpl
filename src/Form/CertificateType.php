<?php

namespace App\Form;

use App\Entity\Certificate;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CertificateType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Surname')
            ->add('name')
            ->add('birthDate')
            ->add('result')
            ->add('sampleDate')
            ->add('testNumber')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Certificate::class,
        ]);
    }
}
