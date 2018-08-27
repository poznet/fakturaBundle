<?php
/**
 * Created by PhpStorm.
 * User: jospeh
 * Date: 26.08.18
 * Time: 10:12
 */

namespace FV\fakturaBundle\src\poznet\FakturaBundle\Service;


use Doctrine\ORM\EntityManagerInterface;
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


    public function generateHTML(Faktura $fv)
    {
        return $this->twig->render('poznetFakturaBundle::print.html.twig', ['faktura' => $fv]);
    }

    public function savePDF(Faktura $fv, $footer = null)
    {
        $this->saveHTML($fv);

        $process = new Process(['wkhtmltopdf', '--no-background', $this->root . '/fv/' . strtr($fv->getNr(), ['/' => '-']) . '.html', , $this->root . '/fv/' . strtr($fv->getNr(), ['/' => '-']) . '.pdf']);
        $process->run();

        $process->mustRun();

    }

    public function saveHTML(Faktura $fv)
    {
        $this->checkDir();
        $path = $this->root . '/fv/' . strtr($fv->getNr(), ['/' => '-']) . '.html';
        $html = $this->generateHTML($fv);
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