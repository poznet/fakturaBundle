<?php
/**
 * Created by PhpStorm.
 * User: pozyc
 * Date: 23.06.2018
 * Time: 12:34
 */

namespace FakturaBundle\src\poznet\FakturaBundle\EventSubscriber;


use poznet\FakturaBundle\Model\Pozycja;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\VarDumper\VarDumper;

class FakturaFormSubscriber implements EventSubscriberInterface
{
    private $kernel;

    public function __construct(KernelInterface $kernel)
    {
        $this->kernel = $kernel;

    }

    public static function getSubscribedEvents()
    {
        return [
            FormEvents::PRE_SET_DATA => 'preSetData',
            FormEvents::SUBMIT => 'Submit'
        ];
    }

    public function preSetData(FormEvent $event)
    {

        $fv = $event->getData();

        // nowa  fv
        if (!$fv || null === $fv->getId()) {
            $service = $this->kernel->getContainer()->get('poznet_faktura_service');
            $fv->setTerminPlatnosci($service->generateTerminPlatnosci());
            $fv->setNr($service->generateNumber($fv));
        }

        //dodonie dodatkowych pol

        $p = new Pozycja();
        $p2 = new Pozycja();
        $p3 = new Pozycja();
        $fv->getPozycje()->add($p);
        $fv->getPozycje()->add($p2);
        $fv->getPozycje()->add($p3);
    }

    // zlicza brutto pozycji
    //zliczanie sum
    // wywala pozycje 0rowe

    public function Submit(FormEvent $event)
    {

        $fv = $event->getData();
        $pozycje = $fv->getPozycje();
        $razem = 0;
        $razemVat=0;
        $razemNetto=0;
        foreach ($pozycje as $p) {
            $p->calculate();
            if ($p->getRazem() == Null) {
                $fv->removePozycja($p);
                continue;
            }

            $razem += $p->getRazem();
            $razemVat += ($p->getNetto()* $p->getVat())/100;
            $razemNetto+= $p->getNetto();

        }
        $fv->setPozycje($pozycje);
        $fv->setRazemNetto($razemNetto);
        $fv->setRazemVat($razemVat);
        $fv->setRazemSuma($razem);
        $fv->setRazemBrutto($razem);
        $event->setData($fv);

    }

}