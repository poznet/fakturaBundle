<?php
/**
 * Created by PhpStorm.
 * User: pozyc
 * Date: 24.02.2019
 * Time: 22:16
 */

namespace FakturaBundle\src\poznet\FakturaBundle\Twig;


use poznet\FakturaBundle\Entity\Faktura;
use Twig\Extension\AbstractExtension;

class SprzedawcaExtension extends AbstractExtension
{
    private $dane;

    public function __construct($dane)
    {
        $this->dane = $dane;

    }

    public function getFunctions()
    {
        return [
            new \Twig_Function('sprzedawca', [$this, 'getSprzedawca']),
        ];
    }


    public function getSprzedawca(Faktura $faktura)
    {
        if ($faktura->getSprzedawca() != '') {
            return $faktura->getSprzedawca();
        } else {
            return $this->getDefaultData();
        }
    }

    private function getDefaultData()
    {
        $dane = $this->dane;
        return $dane['nazwa'] . '<br />' . $dane['adres1'] . ', ' . $dane['adres2'] . ',  NIP: ' . $dane['nip'] . '
        <br />Konto bankowe:  ' . $dane['konto'];


    }

}