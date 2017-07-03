<?php

namespace Mediashare\FaqBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $list = $this->getDoctrine()->getRepository('MediashareFaqBundle:faq')->findAll();
        return $this->render('MediashareFaqBundle:Default:index.html.twig', array('list' => $list));
    }
}
