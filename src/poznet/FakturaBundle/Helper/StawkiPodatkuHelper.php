<?php
/**
 * Created by PhpStorm.
 * User: jospeh
 * Date: 17.01.19
 * Time: 22:26
 */

namespace FakturaBundle\src\poznet\FakturaBundle\Helper;


use FakturaBundle\src\poznet\FakturaBundle\Model\Stawki;
use poznet\FakturaBundle\Entity\Faktura;

class StawkiPodatkuHelper
{
    private static $domyslneStawki = ['23%', '8%', '5%', '0%', 'np'];
    private static $stawki = [];

    public static function getDomyslneStawki()
    {
        return self::$domyslneStawki;
    }


    public static function generate(Faktura $fv)
    {
        foreach (self::$domyslneStawki as $p) {
            self::addToStawki($p, 0, 0);

        }

        $pozycje = $fv->getPozycje();
        $razem = 0;
        $razemVat = 0;
        $razemNetto = 0;

        foreach ($pozycje as $p) {
            $razem += $p->getRazem();
            $razemVat += ($p->getNetto() * $p->getVat()) / 100;
            $razemNetto += $p->getNetto();
            self::addToStawki($p->getVat().'%', $p->getNetto(), ($p->getNetto() * $p->getVat()) / 100);
        }

        return self::$stawki;
    }


    private function addToStawki($vat, $netto, $podatek)
    {
        if (array_key_exists($vat, self::$stawki)) {
            $s = self::$stawki[$vat];
            if ($s instanceof Stawki) {
                $s->setNazwa($vat);
                $s->setNetto($s->getNetto() + $netto);
                $s->setVat($s->getVat() + $podatek);
                $s->calculate();
                self::$stawki[$vat] = $s;
            }
        } else {
            $s = new Stawki();
            $s->setNazwa($vat);
            $s->setNetto($netto);
            $s->setVat($podatek);
            $s->calculate();
            self::$stawki[$vat] = $s;
        }
    }


}