<?php

namespace Mediashare\PageBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($path)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $entity = $em->getRepository('MediasharePageBundle:Page')->findOneBy(array('path' => $path));

        return $this->render('MediasharePageBundle:Default:index.html.twig', array('page' => $entity));
    }
}
