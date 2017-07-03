<?php

namespace Mediashare\ScriptBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
     /**
     * Lists all Script entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('MediashareScriptBundle:Script')->findAll();

        return $this->render('MediashareScriptBundle:Default:index.html.twig', array(
            'entities' => $entities,
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

        return $this->render('MediashareScriptBundle:Default:show.html.twig', array(
            'entity'      => $entity,
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
