<?php
/**
 * Created by PhpStorm.
 * User: jospeh
 * Date: 17.01.19
 * Time: 22:20
 */

namespace FakturaBundle\src\poznet\FakturaBundle\Model;


class Stawki
{



    private $nazwa;
    private $netto;
    private $vat;
    private $brutto;



    public function __toString()
    {
        // TODO: Implement __toString() method.
        return "".$this->nazwa;
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
    public function getNetto()
    {
        return $this->netto;
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

    public function calculate(){
        $this->setBrutto($this->getNetto()+$this->getVat());
    }




}