<?php
/**
 * Created by PhpStorm.
 * User: pozyc
 * Date: 17.06.2018
 * Time: 12:14
 */

namespace FakturaBundle\src\poznet\FakturaBundle\Service;
use poznet\FakturaBundle\Entity\Faktura;

/**
 * Class FakturaNumberService
 * @package FakturaBundle\src\poznet\FakturaBundle\Service
 */
class FakturaNumberService
{
    /**
     * @param $last
     */
    public function generate(Faktura $fv)
    {
        if (!$fv instanceof Faktura)
            return new \Exception("Need FV Entity for  number generation");
        $last = $fv->getNr();

        $tab = explode('/', $last);
        if (count($tab) == 0) {
            return '1/' . $fv->getDataWystawienia()->format('m') . '/' . $fv->getDataWystawienia()->format('Y');
        }
        $x = $tab[0];
        $tab[0] = (int)$x + 1;
        $tab[1]=$fv->getDataWystawienia()->format('m');
        $tab[2]= $fv->getDataWystawienia()->format('Y');
        $nr = implode('/', $tab);

        return $nr;
    }

}