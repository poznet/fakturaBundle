<?php

namespace poznet\FakturaBundle\Form;

use FakturaBundle\src\poznet\FakturaBundle\EventSubscriber\FakturaFormSubscriber;
use FakturaBundle\src\poznet\FakturaBundle\Model\PozycjaModel;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FakturaType extends AbstractType
{
    private $kernel;


    public function __construct(KernelInterface $kernel)
    {
        $this->kernel=$kernel;

    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nr')
            ->add('dataWystawienia',null,['widget'=>'single_text'])
            ->add('dataUslugi',null,['widget'=>'single_text','label'=>'Data wykonania usługi'])
            ->add('nabywca')
            ->add('nabywcaNip')
            ->add('pozycje',CollectionType::class,[
                'entry_type'=>PozycjaType::class,
                'entry_options' => ['label' => false],
                'allow_add' => true ,
                'allow_delete' => true
            ])
            ->add('razemNetto',TextType::class,['attr'=>['class'=>'text-right' ]])
            ->add('razemVat',TextType::class,['attr'=>['class'=>'text-right' ]])
            ->add('razemBrutto',TextType::class,['attr'=>['class'=>'text-right' ]])
            ->add('platnosc',ChoiceType::class,['choices'=>[
                'przelew'=>'przelew',
                'gotówka'=>'gotowka',
                'płatność kartą'=>'karta'
            ]])
            ->add('terminPlatnosci',null,['widget'=>'single_text'])
            ->add('uwagi')
            ->add('zaplacone',CheckboxType::class,['label'=>'Faktura zapłacona','mapped'=>false,'required'=>false])
            ->add('stawki',HiddenType::class,['mapped'=>false])
            ->add("Zapisz",SubmitType::class,['attr'=>['class'=>'btn-primary']])
            ;
        $builder->addEventSubscriber(new FakturaFormSubscriber($this->kernel));

    }


    /**
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
