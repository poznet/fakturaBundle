<?php
/**
 * Created by PhpStorm.
 * User: pozyc
 * Date: 17.06.2018
 * Time: 11:39
 */

namespace FakturaBundle\src\poznet\FakturaBundle\EventListener;


use Doctrine\ORM\Event\LifecycleEventArgs;
use FakturaBundle\src\poznet\FakturaBundle\Service\FakturaNumberService;
use poznet\FakturaBundle\Entity\Faktura;

/**
 * Class FakturaNumberListener
 * @package FakturaBundle\src\poznet\FakturaBundle\EventListener
 * Numeracja miesięczna FV
 */
class FakturaNumberListener
{
    private $em;
    private $nrService;

    public function __construct(FakturaNumberService $service)
    {
        $this->nrService = $service;
    }


    public function postPersist(LifecycleEventArgs $args)
    {
        $this->em = $args->getEntityManager();
        $entity = $args->getEntity();

        if ($entity instanceof Faktura) {
            $last=$this->em->getRepository('poznetFakturaBundle:Faktura')->findLastNumberForMonth($entity->getDataWystawienia());
            $nr=$this->nrService->generate($last);
            $entity->setNr($nr);
            $this->em->flush($entity);


        }
    }
}