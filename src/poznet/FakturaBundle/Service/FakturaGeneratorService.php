<?php
/**
 * Created by PhpStorm.
 * User: jospeh
 * Date: 26.08.18
 * Time: 10:12
 */

namespace FakturaBundle\src\poznet\FakturaBundle\Service;


use Doctrine\ORM\EntityManagerInterface;
use FakturaBundle\src\poznet\FakturaBundle\Helper\StawkiPodatkuHelper;
use poznet\FakturaBundle\Entity\Faktura;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Process\Process;

class FakturaGeneratorService
{

    private $em;
    private $twig;
    private $root;

    /**
     * FakturaGeneratorService constructor.
     * @param $em
     * @param $twig
     */
    public function __construct(EntityManagerInterface $em, \Twig_Environment $twig, $root)
    {
        $this->em = $em;
        $this->twig = $twig;
        $this->root = $root . '/..';
    }


    public function generateHTML(Faktura $fv, $footer = null)
    {
        $stawki=StawkiPodatkuHelper::generate($fv);
        return $this->twig->render('poznetFakturaBundle::print.html.twig', ['faktura' => $fv,'footer'=>$footer,'stawki'=>$stawki]);
    }

    public function savePDF(Faktura $fv, $footer = ' ')
    {
        $this->saveHTML($fv,$footer);

        $process = new Process(['wkhtmltopdf', '--no-background', $this->root . '/fv/' . strtr($fv->getNr(), ['/' => '-']) . '.html',$this->root . '/fv/' . strtr($fv->getNr(), ['/' => '-']) . '.pdf']);
        $process->run();

        $process->mustRun();

    }

    public function saveHTML(Faktura $fv, $footer = null)
    {
        $this->checkDir();
        $path = $this->root . '/fv/' . strtr($fv->getNr(), ['/' => '-']) . '.html';
        $html = $this->generateHTML($fv,$footer);
        $fs = new Filesystem();
        $fs->remove($path);
        $fs->appendToFile($path, $html);

    }

    private function checkDir()
    {
        $fs = new Filesystem();
        if (!$fs->exists($this->root . '/fv'))
            $fs->mkdir($this->root . '/fv');
    }
}