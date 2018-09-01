<?php
/**
 * Created by PhpStorm.
 * User: pozyc
 * Date: 17.06.2018
 * Time: 12:14
 */

namespace FakturaBundle\src\poznet\FakturaBundle\Service;

use Doctrine\ORM\EntityManagerInterface;
use poznet\FakturaBundle\Entity\Faktura;
use Symfony\Component\HttpKernel\KernelInterface;

/**
 * Class FakturaNumberService
 * @package FakturaBundle\src\poznet\FakturaBundle\Service
 */
class FakturaNumberService
{
    private $kernel;
    private $em;

    /**
     * @param $last
     */

    public function __construct(KernelInterface $kernel,EntityManagerInterface $entityManager)
    {
        $this->kernel = $kernel;
        $this->em=$entityManager;
    }

    /**
     * @param Faktura $fv
     * @return \Exception|string
     */
    public function generateNumber(Faktura $fv)
    {
        $ostatnia=$this->em->getRepository("poznetFakturaBundle:Faktura")->findBy([],["id"=>"DESC"],1);
        if(count($ostatnia)>0)
            $fv=$ostatnia[0];

        if (!$fv instanceof Faktura)
            return new \Exception("Need FV Entity for  number generation");
        $last = $fv->getNr();

        $tab = explode('/', $last);
        if (count($tab) == 0) {
            return '1/' . $fv->getDataWystawienia()->format('m') . '/' . $fv->getDataWystawienia()->format('Y');
        }
        $dzis=new \DateTime('now');

        // nowy miesiac , nowa numeracja
        if($fv->getDataWystawienia()->format('m')!=$dzis->format('m'))
            return '1/' . $dzis->format('m') . '/' . $fv->getDataWystawienia()->format('Y');

        $x = $tab[0];
        $tab[0] = (int)$x + 1;
        $tab[1] = $fv->getDataWystawienia()->format('m');
        $tab[2] = $fv->getDataWystawienia()->format('Y');
        $nr = implode('/', $tab);

        return $nr;
    }

    /**
     * sets  default payment date
     * @param Faktura $fv
     * @return \Exception
     */
    public function generateTerminPlatnosci()
    {

        if ($this->kernel->getContainer()->hasParameter('faktura_termin_days')) {
            $days = $this->kernel->getContainer()->getParameter('faktura_termin_days');
        } else {
            $days = 14;
        }
        $data = new \DateTime('now + ' . $days . ' days');
        return $data;
    }


}