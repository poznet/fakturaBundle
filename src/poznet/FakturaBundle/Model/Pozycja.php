<?php
/**
 * Created by PhpStorm.
 * User: pozyc
 * Date: 24.06.2018
 * Time: 12:18
 */

namespace poznet\FakturaBundle\Model;

/**
 * Class PozycjaModel
 * @package FakturaBundle\src\poznet\FakturaBundle\Model
 */
class Pozycja
{

    const VAT23 = 23;
    const VAT8 = 8;

    private $nazwa;
    private $ilosc;
    private $cena;
    private $netto;
    private $vat;
    private $brutto;
    private $razem;


    /**
     * PozycjaModel constructor.
     */
    public function __construct()
    {
        $this->vat = self::VAT23;
    }

    public function calculate()
    {
        if ($this->netto > 0) {
            $this->netto = $this->ilosc * $this->cena;
            $this->brutto = $this->netto * (1 + ($this->vat / 100));
            $this->razem = $this->brutto;
        } elseif ($this->brutto > 0) {
            $this->netto = $this->brutto / (1 + ($this->vat / 100));
            $this->razem = $this->brutto;
        }


    }

    /**
     * @return mixed
     */
    public function getNazwa()
    {
        return $this->nazwa;
    }

    /**
     * @param mixed $nazwa
     */
    public function setNazwa($nazwa)
    {
        $this->nazwa = $nazwa;
    }

    /**
     * @return mixed
     */
    public function getIlosc()
    {
        return $this->ilosc;
    }

    /**
     * @param mixed $ilosc
     */
    public function setIlosc($ilosc)
    {
        $this->ilosc = $ilosc;
    }

    /**
     * @return mixed
     */
    public function getCena()
    {
        return $this->cena;
    }

    /**
     * @param mixed $cena
     */
    public function setCena($cena)
    {
        $this->cena = $cena;
    }

    /**
     * @return mixed
     */
    public function getNetto()
    {
        return $this->netto;
        $this->calculate();
    }

    /**
     * @param mixed $netto
     */
    public function setNetto($netto)
    {
        $this->netto = $netto;
    }

    /**
     * @return mixed
     */
    public function getVat()
    {
        return $this->vat;
    }

    /**
     * @param mixed $vat
     */
    public function setVat($vat)
    {
        $this->vat = $vat;
    }

    /**
     * @return mixed
     */
    public function getBrutto()
    {
        return $this->brutto;
    }

    /**
     * @param mixed $brutto
     */
    public function setBrutto($brutto)
    {
        $this->brutto = $brutto;
    }

    /**
     * @return mixed
     */
    public function getRazem()
    {
        return $this->razem;
    }

    /**
     * @param mixed $razem
     */
    public function setRazem($razem)
    {
        $this->razem = $razem;
    }


}