<?php
/**
 * Created by PhpStorm.
 * User: pozyc
 * Date: 24.02.2019
 * Time: 22:16
 */

namespace FakturaBundle\src\poznet\FakturaBundle\Twig;


use Doctrine\ORM\EntityManagerInterface;
use poznet\FakturaBundle\Entity\Faktura;
use ScraperBundle\Entity\Firma;
use Twig\Extension\AbstractExtension;

class SprzedawcaExtension extends AbstractExtension
{
    private $dane;
    private $em;

    public function __construct($dane, EntityManagerInterface $entityManager)
    {
        $this->dane = $dane;
        $this->em = $entityManager;
    }

    public function getFunctions()
    {
        return [
            new \Twig_Function('sprzedawca', [$this, 'getSprzedawca']),
        ];
    }


    public function getSprzedawca(Faktura $faktura)
    {

        if ($faktura->getFirmaId() == 0) {
            return $this->getDefaultData();
        } else {
            $firm = $this->em->getRepository("ScraperBundle:Firma")->findOneById($faktura->getFirmaId());
            if ($firm instanceof Firma) {
                return $firm->getNazwa() . '<br/>' . $firm->getAdres1() . ', ' . $firm->getAdres2() . ', NIP: ' . $firm->getNip() . '
                       <br />Konto bankowe:  ' . $firm->getKonto();


            }


        }
    }

    private function getDefaultData()
    {
        $dane = $this->dane;
        return $dane['nazwa'] . '<br />' . $dane['adres1'] . ', ' . $dane['adres2'] . ',  NIP: ' . $dane['nip'] . '
        <br />Konto bankowe:  ' . $dane['konto'];


    }

}