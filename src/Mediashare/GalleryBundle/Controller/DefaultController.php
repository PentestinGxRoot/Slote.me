<?php

namespace Mediashare\GalleryBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('MediashareGalleryBundle:Category');
        $repoGallery = $em->getRepository('MediashareGalleryBundle:Gallery');
        $category = $repo->find($id);
        if (!$category) {
            return $this->redirectToRoute('mediashare_app_homepage');
        }
        $galleries = $repoGallery->findBy(array('category' => $category), array('position' => 'ASC'));

        return $this->render('MediashareGalleryBundle:Default:index.html.twig', array('galleries' => $galleries, 'category' => $category));
    }

    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $gallery = $em->getRepository('MediashareGalleryBundle:Gallery')->find($id);
        if (!$gallery) {
            return $this->redirectToRoute('mediashare_app_homepage');
        }
        return $this->render('MediashareGalleryBundle:Default:show.html.twig', array(
            'gallery' => $gallery
        ));
    }
}
