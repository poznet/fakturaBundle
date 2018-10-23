<?php

namespace poznet\FakturaBundle\Form;

use FakturaBundle\src\poznet\FakturaBundle\EventSubscriber\FakturaFormSubscriber;
use FakturaBundle\src\poznet\FakturaBundle\Model\PozycjaModel;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PozycjaType extends AbstractType
{


    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nazwa',null,['label'=>false,'attr'=>['class'=>'poz_nazwa']])
            ->add('ilosc',null,['label'=>false,'attr'=>['class'=>'poz_ilosc']])
            ->add('cena',null,['label'=>false,'attr'=>['class'=>'poz_cena']])
            ->add('vat',null,['label'=>false,'attr'=>['class'=>'poz_vat']])
            ->add('razem',null,['label'=>false,'attr'=>['class'=>'poz_razem']])


            ;


    }


    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'poznet\FakturaBundle\Model\Pozycja'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'poznet_fakturabundle_faktura_pozycja';
    }


}
