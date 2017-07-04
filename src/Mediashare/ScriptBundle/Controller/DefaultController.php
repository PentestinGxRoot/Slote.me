<?php

namespace Mediashare\ScriptBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Finder\Finder;

class DefaultController extends Controller
{
     /**
     * Lists all Script entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('MediashareScriptBundle:Script')->findBy(array(), array('id' => 'DESC'));

        return $this->render('MediashareScriptBundle:Default:index.html.twig', array(
            'entities' => $entities,
        ));
    }

     /**
     * Lists all Script entities.
     *
     */
    public function listAction($type)
    {
        $em = $this->getDoctrine()->getManager();
        if($type == 0){
          $title = "Backdoor";
          $ico = "http://roch.blondiaux.xyz/wp-content/uploads/2016/08/backdoorlogo28229.jpg.png";
        }elseif($type == 1) {
          $title = "Malware";
          $ico = "http://kine.eurobytech.com/wp-content/uploads/revslider/slider-beewair/Bacteria_Virus.png";
        }elseif($type == 2) {
          $title = "Remote Access Tool";
          $ico = "";
        }elseif($type == 3) {
          $title = "Helper";
          $ico = "http://vignette1.wikia.nocookie.net/simpsons/images/2/2c/Santa%27s_Little_Helper.png/revision/latest?cb=20151011181138";
        }
        $entities = $em->getRepository('MediashareScriptBundle:Script')->findBy(array('type' => $type), array('id' => 'DESC'));
        $title = $title." list.";
        return $this->render('MediashareScriptBundle:Default:list.html.twig', array(
            'entities' => $entities,
            'title' => $title,
            'ico' => $ico
        ));
    }

    /**
     * Finds and displays a Script entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MediashareScriptBundle:Script')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Script entity.');
        }

        $name_file = $entity->getThispath();
        $finder = new Finder();
        $finder->files()->in("script/");
        $finder->files()->name($name_file);
        foreach ($finder as $file) {
            // Dump the absolute path
            // var_dump($file->getRealPath());

            // Dump the relative path to the file, omitting the filename
            // var_dump($file->getRelativePath());

            // Dump the relative path to the file
            // var_dump($file->getRelativePathname());
            $contents = $file->getContents();
        }
        return $this->render('MediashareScriptBundle:Default:show.html.twig', array(
            'entity'      => $entity,
            'contents' => $contents
        ));
    }

    /**
     * Download $id Script.
     *
     */
    public function downloadAction($path, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MediashareScriptBundle:Script')->find($id);

        return $this->render('MediashareScriptBundle:Default:show.html.twig', array(
            'entity' => $entity,
        ));
    }

}
