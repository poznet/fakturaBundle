<?php

namespace poznet\FakturaBundle\Repository;

/**
 * FakturaRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class FakturaRepository extends \Doctrine\ORM\EntityRepository
{

    public function findLastNumberForMonth(\DateTime $data, $firm = null)
    {
        if($firm==0) $firm=null;
        if ($firm != null) {
            $result = $this->getEntityManager()->createQuery('
        SELECT F from FakturaBundle:Faktura F
        WHERE MONTH(F.data_wystawienie)=:miesiac
        AND WHERE F.sprzedawcaId=:firm
        ORDER BY F.id DESC  ')
                ->setParameter('firm', $firm);
        } else {
            $result = $this->getEntityManager()->createQuery('
        SELECT F from FakturaBundle:Faktura F
        WHERE MONTH(F.data_wystawienie)=:miesiac
        ORDER BY F.id DESC 
        ');
        }
        $result
            ->setParameter('miesiac', $data->format('m'))
            ->getFirstResult();

        return $result;
    }

    public function findByMiesiac($rok, $miesiac, $firm = null)
    {
        if($firm==0) $firm=null;
        $qb = $this->createQueryBuilder('f')
            ->andWhere('f.dataWystawienia  LIKE :forDate');
        if ($firm != null) {
            $qb->andWhere('f.sprzedawcaId  LIKE :firm')
                ->setParameter('firm', $firm);
        }
        $qb
            ->setParameter('forDate', $rok . '-' . $miesiac . '-%');

        return $qb->getQuery()->execute();
    }
}
