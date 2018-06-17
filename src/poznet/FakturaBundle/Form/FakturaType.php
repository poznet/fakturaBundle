<?php

namespace poznet\FakturaBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FakturaType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('nr')->add('dataWystawienia')->add('dataUslugi')->add('nabywca')->add('nabywcaNip')->add('nabywcaId')->add('pozycje')->add('razemNetto')->add('razemVat')->add('razemBrutto')->add('platnosc')->add('terminPlatnosci')->add('uwagi');
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'poznet\FakturaBundle\Entity\Faktura'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'poznet_fakturabundle_faktura';
    }


}
