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
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\VarDumper\VarDumper;

/**
 * Class FakturaNumberService
 * @package FakturaBundle\src\poznet\FakturaBundle\Service
 */
class FakturaNumberService
{
    private $kernel;
    private $em;
    private $container;

    /**
     * @param $last
     */

    public function __construct(KernelInterface $kernel, EntityManagerInterface $entityManager)
    {
        $this->kernel = $kernel;
        $this->em = $entityManager;
        $this->container = $kernel->getContainer();
    }

    /**
     * @param Faktura $fv
     * @return \Exception|string
     */
    public function generateNumber(Faktura $fv, $user_id = 0)
    {
        if ($user_id > 0) {
            $ostatnia = $this->em->getRepository("poznetFakturaBundle:Faktura")->findBy(['nabywcaId' => $user_id], ["id" => "DESC"], 1);
        } else {
            $ostatnia = $this->em->getRepository("poznetFakturaBundle:Faktura")->findBy([], ["id" => "DESC"], 1);
        }

        if (count($ostatnia) > 0)
            $fv = $ostatnia[0];

        if (!$fv instanceof Faktura)
            return new \Exception("Need FV Entity for  number generation");
        $last = $fv->getNr();

        $tab = explode('/', $last);
        if (count($tab) == 0) {
            $txt = '1/' . $fv->getDataWystawienia()->format('m') . '/' . $fv->getDataWystawienia()->format('Y');
            if ($user_id > 0)
                $txt = '1/' . $user_id . '/' . $fv->getDataWystawienia()->format('m') . '/' . $fv->getDataWystawienia()->format('Y');
            return $txt;
        }
        $dzis = new \DateTime('now');

        // nowy miesiac , nowa numeracja
        if ($fv->getDataWystawienia()->format('m') != $dzis->format('m')) {
            $txt = '1/' . $dzis->format('m') . '/' . $fv->getDataWystawienia()->format('Y');
            if ($user_id > 0)
                $txt = '1/' . $user_id . '/' . $dzis->format('m') . '/' . $fv->getDataWystawienia()->format('Y');
            return $txt;
        }

        $index = 0;
        if ($this->container->hasParameter('fv_numer_prefix')) {
            $y = explode('/', $this->container->getParameter('fv_numer_prefix'));
            if ($tab[0] == $y[0])
                $index++;
        }

        if ($user_id > 0) {
            $x = $tab[$index];
            $tab[$index] = (int)$x + 1;
            $tab[$index + 1] = (int)$user_id;
            $tab[$index + 2] = $fv->getDataWystawienia()->format('m');
            $tab[$index + 3] = $fv->getDataWystawienia()->format('Y');
            $nr = implode('/', $tab);
        } else {
            $x = $tab[$index];
            $tab[$index] = (int)$x + 1;
            $tab[$index + 1] = $fv->getDataWystawienia()->format('m');
            $tab[$index + 2] = $fv->getDataWystawienia()->format('Y');
            $nr = implode('/', $tab);
        }

        if ($this->container->hasParameter('fv_numer_prefix')) {
            $y = explode('/', $this->container->getParameter('fv_numer_prefix'));
            if ($tab[0] != $y[0])
            $nr = $this->container->getParameter('fv_numer_prefix') . $nr;
        }
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
            $days = 7;
        }
        $data = new \DateTime('now + ' . $days . ' days');
        return $data;
    }


}