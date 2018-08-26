<?php
/**
 * Created by PhpStorm.
 * User: jospeh
 * Date: 26.08.18
 * Time: 20:52
 */

namespace poznet\FakturaBundle\Controller;


use poznet\FakturaBundle\Entity\Faktura;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class FakturaController
 * @package FV\fakturaBundle\src\poznet\FakturaBundle\Controller
 */
class FakturaController extends Controller
{

    /**
     * @Route("/fv/{name}", name="faktura")
     */
    public function fvAction($name){
        $root=$this->getParameter("kernel.root_dir");
        $fs=new Filesystem();
        $path = $root . '/../fv/' . $name;

        $testname=strtr($name,['-'=>'/']);
        $tab=explode('.',$testname);
        $testname=$tab[0];
        $em=$this->get('doctrine.orm.entity_manager');
        $fv=$em->getRepository("poznetFakturaBundle:Faktura")->findOneByNr($testname);
        if(! $fv instanceof  Faktura)
            return $this->createNotFoundException('Brak FV');
        $user=$this->get('security.token_storage')->getToken()->getUser();
        if(($fv->getNabywcaId()!=$user->getId()) &&
            ($user->getUsername()!='admin')
        )
            return $this->createAccessDeniedException(" Fv Innego usera");

        $r=new Response();
        if($fs->exists($path)){
            $r->headers->set('Content-type' , 'application/pdf');
            $raw=file_get_contents($path);

        }

        $r->setContent($raw);
        return $r;

    }

}