<?php
/**
 * Created by PhpStorm.
 * User: pozyc
 * Date: 23.06.2018
 * Time: 12:34
 */

namespace FakturaBundle\src\poznet\FakturaBundle\EventSubscriber;


use FakturaBundle\src\poznet\FakturaBundle\Helper\StawkiPodatkuHelper;
use FakturaBundle\src\poznet\FakturaBundle\Model\Stawki;
use poznet\FakturaBundle\Entity\Faktura;
use poznet\FakturaBundle\Model\Pozycja;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\VarDumper\VarDumper;

class FakturaFormSubscriber implements EventSubscriberInterface
{
    private $kernel;
    private $stawki;


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
        $tab = [];
        if (count($fv->getPozycje()) > 0) {
            foreach ($fv->getPozycje() as $pozycja)
                array_push($tab, $pozycja);
        } else {
            array_push($tab, new Pozycja());
            array_push($tab, new Pozycja());
            array_push($tab, new Pozycja());
            array_push($tab, new Pozycja());
            array_push($tab, new Pozycja());
            array_push($tab, new Pozycja());
            array_push($tab, new Pozycja());
            array_push($tab, new Pozycja());
            array_push($tab, new Pozycja());
            array_push($tab, new Pozycja());
        }
        $fv->setPozycje($tab);
        $fv->calculate();

    }

    // zlicza brutto pozycji
    // zliczanie sum
    // wywala pozycje 0rowe

    public function Submit(FormEvent $event)
    {

        $fv = $event->getData();
        $pozycje = $fv->getPozycje();
        $form=$event->getForm();
        $zaplacone=$form->get("zaplacone")->getData();
        $fv->setStatus(Faktura::STATUS_UNPAID);

        if($zaplacone==true){
            $fv->setStatus(Faktura::STATUS_PAID);
        }
        $razem = 0;
        $razemVat = 0;
        $razemNetto = 0;
        foreach ($pozycje as $p) {
            $p->calculate();
            if ($p->getRazem() == Null) {
                $fv->removePozycja($p);
                continue;
            }


            $razem += $p->getRazem();
            $v=$p->getVat();
            if($v='np')
                $v=0;
            $razemVat += ($p->getNetto() * $v) / 100;
            $razemNetto += $p->getNetto();



        }
        $fv->setPozycje($pozycje);
        $fv->setRazemNetto($razemNetto);
        $fv->setRazemVat($razemVat);
        $fv->setRazemSuma($razem);
        $fv->setRazemBrutto($razem);
        $fv->setStawki($this->stawki);
        $event->setData($fv);

    }



}