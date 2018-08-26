<?php
/**
 * Created by PhpStorm.
 * User: jospeh
 * Date: 26.08.18
 * Time: 21:42
 */

namespace FV\fakturaBundle\src\poznet\FakturaBundle\Service;


use Doctrine\ORM\EntityManagerInterface;
use poznet\FakturaBundle\Entity\Faktura;

class FakturaFinderService
{
    private $em;
    private $root;

    /**
     * FakturaFinderService constructor.
     * @param $em
     */
    public function __construct(EntityManagerInterface $em,$root)
    {
        $this->em = $em;
        $this->root = $root.'/..';
    }

    public function findFileNameByOrderId($id){
        $fv=$this->findByOrderId($id);
        if($fv==null) return null;
        $name=strtr($fv->getNr(),['/'=>'-']) . '.pdf';
        $path = $this->root . '/fv/' . strtr($fv->getNr(),['/'=>'-']) . '.pdf';
        if(file_exists($path))
        return $name;
        return null;

    }

    public function findByOrderId($id)
    {
        $fv=$this->em->getRepository("poznetFakturaBundle:Faktura")->findOneByZlecenieId($id);
        if($fv instanceof  Faktura)
            return $fv;

        return null;
    }



}