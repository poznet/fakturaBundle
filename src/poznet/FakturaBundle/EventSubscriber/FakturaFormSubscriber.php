<?php
/**
 * Created by PhpStorm.
 * User: pozyc
 * Date: 23.06.2018
 * Time: 12:34
 */

namespace FakturaBundle\src\poznet\FakturaBundle\EventSubscriber;


use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\HttpKernel\KernelInterface;

class FakturaFormSubscriber implements EventSubscriberInterface
{
    private  $kernel;

    public function __construct(KernelInterface $kernel)
    {
        $this->kernel=$kernel;

    }

    public static function getSubscribedEvents()
    {
        return array(FormEvents::PRE_SET_DATA => 'preSetData');
    }

    public function preSetData(FormEvent $event){

        $fv = $event->getData();

        // nowa  fv
        if (!$fv || null === $fv->getId()) {
            $service=$this->kernel->getContainer()->get('poznet_faktura_service');
            $fv->setTerminPlatnosci($service->generateTerminPlatnosci());
        }

    }

}