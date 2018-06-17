<?php
/**
 * Created by PhpStorm.
 * User: pozyc
 * Date: 17.06.2018
 * Time: 11:39
 */

namespace FakturaBundle\src\poznet\FakturaBundle\EventListener;


use Doctrine\ORM\Event\LifecycleEventArgs;
use poznet\FakturaBundle\Entity\Faktura;

/**
 * Class FakturaNumberListener
 * @package FakturaBundle\src\poznet\FakturaBundle\EventListener
 * Numeracja miesięczna FV
 */
class FakturaNumberListener
{
    private $em;


    public function postPersist(LifecycleEventArgs $args)
    {
        $this->em = $args->getEntityManager();
        $entity = $args->getEntity();

        if ($entity instanceof Faktura) {
            if ($entity->getNr() == null) {
                $data = $entity->getDataWystawienia();

            }
        }
    }
}