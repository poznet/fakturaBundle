<?php
/**
 * Created by PhpStorm.
 * User: jospeh
 * Date: 16.02.19
 * Time: 22:25
 */

namespace FakturaBundle\src\poznet\FakturaBundle\Twig;


use Doctrine\ORM\EntityManagerInterface;
use ScraperBundle\Entity\Firma;
use ScraperBundle\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class FakutraExtension extends AbstractExtension
{
    private $token;
    private $em;
    private $firma;

    public function __construct(TokenStorageInterface $tokenStorage, EntityManagerInterface $entityManager, $firma)
    {
        $this->token = $tokenStorage;
        $this->em = $entityManager;
        $this->firma = $firma;
    }

    public function getFunctions()
    {
        new TwigFilter('daneFirmy', [$this, 'getFirmData']);
    }


    public function getFirmData()
    {
        $user = $this->token->getToken()->getUser();
        if ($user instanceof User) {
            if ($user->getFirma() instanceof Firma) {
                $f = $user->getFirma();
                return
                    $f->getNazwa() . '<br/>' .
                    $f->getAdres1() . '<br/>' .
                    $f->getAdres2() . '<br/>' .
                    'NIP: ' . $f->getNip() . '<br/>' .
                    'Konto bankowe:  ' . $f->getKonto() . '<br/>';
            } else {
                return $this->getDefaultData();
            }
        }

    }


    private function getDefaultData()
    {
        return
            $this->firma['nazwa'] . '<br/>' .
            $this->firma['adres1'] . '<br/>' .
            $this->firma['adres2'] . '<br/>' .
            'NIP: ' . $this->firma['nip'] . '<br/>' .
            'Konto bankowe:  ' . $this->firma['konto'] . '<br/>';

    }

}