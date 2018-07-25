<?php

namespace poznet\FakturaBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use poznet\FakturaBundle\Model\Pozycja;
use Symfony\Component\Validator\Constraints as Assert;
use Kiczort\PolishValidatorBundle\Validator\Constraints  as KiczortAssert;

/**
 * Faktura
 *
 * @ORM\Table(name="faktura")
 * @ORM\Entity(repositoryClass="poznet\FakturaBundle\Repository\FakturaRepository")
 */
class Faktura
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     * @Assert\NotBlank()     *
     * @ORM\Column(name="nr", type="string", length=255, unique=true)
     */
    private $nr;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="data_wystawienia", type="date")
     * @Assert\NotBlank()
     */
    private $dataWystawienia;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="data_uslugi", type="date")
     * @Assert\NotBlank()
     */
    private $dataUslugi;

    /**
     * @var string
     *
     * @ORM\Column(name="nabywca", type="text")
     * @Assert\NotBlank()
     */
    private $nabywca;

    /**
     * @var string
     *
     * @ORM\Column(name="nabywca_nip", type="string", length=100)
     * @Assert\NotBlank()
     * @KiczortAssert\Nip
     */
    private $nabywcaNip;

    /**
     * @var string
     *
     * @ORM\Column(name="nabywca_id", type="integer")
     *
     */
    private $nabywcaId=0;


    /**
     * @var string
     *
     * @ORM\Column(name="zlecenie_id", type="integer")
     *
     */
    private $zlecenieId=0;

    /**
     * @var string
     *
     * @ORM\Column(name="pozycje", type="text")
     */
    private $pozycje;

    /**
     * @var string
     *
     * @ORM\Column(name="razem_netto", type="string", length=255)
     */
    private $razemNetto;

    /**
     * @var string
     *
     * @ORM\Column(name="razem_vat", type="string", length=255)
     */
    private $razemVat;

    /**
     * @var string
     *
     * @ORM\Column(name="razem_suma", type="string", length=255)
     */
    private $razemBrutto;

    /**
     * @var string
     *
     * @ORM\Column(name="platnosc", type="string", length=255)
     * @Assert\NotBlank()
     */
    private $platnosc;

    /**
     * @var string
     *
     * @ORM\Column(name="termin_platnosci", type="date" )
     */
    private $terminPlatnosci;

    /**
     * @var string
     *
     * @ORM\Column(name="uwagi", type="text")
     */
    private $uwagi;


    public function __construct()
    {
        $this->dataUslugi=new \DateTime('now');
        $this->dataWystawienia=new \DateTime('now');
        $this->pozycje= new ArrayCollection();
    }

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set nr.
     *
     * @param string $nr
     *
     * @return Faktura
     */
    public function setNr($nr)
    {
        $this->nr = $nr;

        return $this;
    }

    /**
     * Get nr.
     *
     * @return string
     */
    public function getNr()
    {
        return $this->nr;
    }

    /**
     * Set dataWystawienia.
     *
     * @param \DateTime $dataWystawienia
     *
     * @return Faktura
     */
    public function setDataWystawienia($dataWystawienia)
    {
        $this->dataWystawienia = $dataWystawienia;

        return $this;
    }

    /**
     * Get dataWystawienia.
     *
     * @return \DateTime
     */
    public function getDataWystawienia()
    {
        return $this->dataWystawienia;
    }

    /**
     * Set dataUslugi.
     *
     * @param \DateTime $dataUslugi
     *
     * @return Faktura
     */
    public function setDataUslugi($dataUslugi)
    {
        $this->dataUslugi = $dataUslugi;

        return $this;
    }

    /**
     * Get dataUslugi.
     *
     * @return \DateTime
     */
    public function getDataUslugi()
    {
        return $this->dataUslugi;
    }

    /**
     * Set nabywca.
     *
     * @param string $nabywca
     *
     * @return Faktura
     */
    public function setNabywca($nabywca)
    {
        $this->nabywca = $nabywca;

        return $this;
    }

    /**
     * Get nabywca.
     *
     * @return string
     */
    public function getNabywca()
    {
        return $this->nabywca;
    }

    /**
     * Set nabywcaNip.
     *
     * @param string $nabywcaNip
     *
     * @return Faktura
     */
    public function setNabywcaNip($nabywcaNip)
    {
        $this->nabywcaNip = $nabywcaNip;

        return $this;
    }

    /**
     * Get nabywcaNip.
     *
     * @return string
     */
    public function getNabywcaNip()
    {
        return $this->nabywcaNip;
    }

    /**
     * Set pozycje.
     *
     * @param string $pozycje
     *
     * @return Faktura
     */
    public function setPozycje($pozycje)
    {
        $this->pozycje = $pozycje;

        return $this;
    }

    /**
     * Get pozycje.
     *
     * @return string
     */
    public function getPozycje()
    {
        return $this->pozycje;
    }

    /**
     * Set razemNetto.
     *
     * @param string $razemNetto
     *
     * @return Faktura
     */
    public function setRazemNetto($razemNetto)
    {
        $this->razemNetto = $razemNetto;

        return $this;
    }

    /**
     * Get razemNetto.
     *
     * @return string
     */
    public function getRazemNetto()
    {
        return $this->razemNetto;
    }

    /**
     * Set razemVat.
     *
     * @param string $razemVat
     *
     * @return Faktura
     */
    public function setRazemVat($razemVat)
    {
        $this->razemVat = $razemVat;

        return $this;
    }

    /**
     * Get razemVat.
     *
     * @return string
     */
    public function getRazemVat()
    {
        return $this->razemVat;
    }

    /**
     * Set razemSuma.
     *
     * @param string $razemSuma
     *
     * @return Faktura
     */
    public function setRazemSuma($razemSuma)
    {
        $this->razemSuma = $razemSuma;

        return $this;
    }

    /**
     * Get razemSuma.
     *
     * @return string
     */
    public function getRazemSuma()
    {
        return $this->razemSuma;
    }

    /**
     * Set platnosc.
     *
     * @param string $platnosc
     *
     * @return Faktura
     */
    public function setPlatnosc($platnosc)
    {
        $this->platnosc = $platnosc;

        return $this;
    }

    /**
     * Get platnosc.
     *
     * @return string
     */
    public function getPlatnosc()
    {
        return $this->platnosc;
    }

    /**
     * Set terminPlatnosci.
     *
     * @param string $terminPlatnosci
     *
     * @return Faktura
     */
    public function setTerminPlatnosci($terminPlatnosci)
    {
        $this->terminPlatnosci = $terminPlatnosci;

        return $this;
    }

    /**
     * Get terminPlatnosci.
     *
     * @return string
     */
    public function getTerminPlatnosci()
    {
        return $this->terminPlatnosci;
    }

    /**
     * Set uwagi.
     *
     * @param string $uwagi
     *
     * @return Faktura
     */
    public function setUwagi($uwagi)
    {
        $this->uwagi = $uwagi;

        return $this;
    }

    /**
     * Get uwagi.
     *
     * @return string
     */
    public function getUwagi()
    {
        return $this->uwagi;
    }

    /**
     * @return string
     */
    public function getRazemBrutto()
    {
        return $this->razemBrutto;
    }

    /**
     * @param string $razemBrutto
     */
    public function setRazemBrutto($razemBrutto)
    {
        $this->razemBrutto = $razemBrutto;
    }

    /**
     * @return string
     */
    public function getNabywcaId()
    {
        return $this->nabywcaId;
    }

    /**
     * @param string $nabywcaId
     */
    public function setNabywcaId($nabywcaId)
    {
        $this->nabywcaId = $nabywcaId;
    }

    /**
     * @return string
     */
    public function getZlecenieId()
    {
        return $this->zlecenieId;
    }

    /**
     * @param string $zlecenieId
     */
    public function setZlecenieId($zlecenieId)
    {
        $this->zlecenieId = $zlecenieId;
    }

    /**
     * @param Pozycja $pozycja
     *
     */
    public function removePozycjoa(Pozycja $pozycja)
    {
        $this->pozycje->removeElement($pozycja);
    }



}
