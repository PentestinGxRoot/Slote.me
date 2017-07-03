<?php

namespace Mediashare\GalleryBundle\Controller;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Mediashare\GalleryBundle\Entity\Gallery;
use Mediashare\GalleryBundle\Form\GalleryType;

/**
 * Gallery controller.
 *
 */
class GalleryController extends Controller
{

    /**
     * Lists all Gallery entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $categories = $em->getRepository('MediashareGalleryBundle:Category')->findBy(array('parent' => null), array('position' => 'ASC'));

        return $this->render('MediashareGalleryBundle:Gallery:index.html.twig', array(
            'categories' => $categories,
        ));
    }

    /**
     * Creates a new Gallery entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Gallery();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('admin_gallery_show', array('id' => $entity->getId())));
        }

        return $this->render('MediashareGalleryBundle:Gallery:new.html.twig', array(
            'entity' => $entity,
            'form' => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Gallery entity.
     *
     * @param Gallery $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Gallery $entity)
    {
        $form = $this->createForm(new GalleryType(), $entity, array(
            'action' => $this->generateUrl('admin_gallery_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit',
            array(
                'label' => 'Enregistrer',
                'attr' => array('class' => 'btn btn-success')
            ));

        return $form;
    }

    /**
     * Displays a form to create a new Gallery entity.
     *
     */
    public function newAction()
    {
        $entity = new Gallery();
        $form = $this->createCreateForm($entity);

        return $this->render('MediashareGalleryBundle:Gallery:new.html.twig', array(
            'entity' => $entity,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Gallery entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MediashareGalleryBundle:Gallery')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Gallery entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('MediashareGalleryBundle:Gallery:show.html.twig', array(
            'entity' => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Gallery entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MediashareGalleryBundle:Gallery')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Gallery entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('MediashareGalleryBundle:Gallery:edit.html.twig', array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Creates a form to edit a Gallery entity.
     *
     * @param Gallery $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Gallery $entity)
    {
        $form = $this->createForm(new GalleryType(), $entity, array(
            'action' => $this->generateUrl('admin_gallery_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit',
            array(
                'label' => 'Enregistrer',
                'attr' => array('class' => 'btn btn-success')
            ));

        return $form;
    }

    /**
     * Edits an existing Gallery entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        /** @var Gallery $entity */
        $entity = $em->getRepository('MediashareGalleryBundle:Gallery')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Gallery entity.');
        }

        $originalPictures = new ArrayCollection();
        foreach ($entity->getPictures() as $picture) {
            $originalPictures->add($picture);
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            foreach ($originalPictures as $picture) {
                if ($entity->getPictures()->contains($picture) == false) {
                    $entity->getPictures()->removeElement($picture);
                    $em->remove($picture);
                }
            }
            $em->flush();

            return $this->redirect($this->generateUrl('admin_gallery_show', array('id' => $id)));
        }

        return $this->render('MediashareGalleryBundle:Gallery:edit.html.twig', array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Gallery entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('MediashareGalleryBundle:Gallery')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Gallery entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('admin_gallery'));
    }

    /**
     * Creates a form to delete a Gallery entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_gallery_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit',
                array(
                    'label' => 'Supprimer',
                    'attr' => array('class' => 'btn btn-danger')
                ))
            ->getForm();
    }

    public function sortAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $value = $request->get('value');
        /** @var Gallery $entity */
        $entity = $em->getRepository('MediashareGalleryBundle:Gallery')->find($id);
        $entity->setPosition($value);
        $em->persist($entity);
        $em->flush();
        return new JsonResponse(array('result' => 'OK'));
    }

    /**
     * Get subcat by ajax.
     *
     */
    public function subAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        /** @var Category $entity */
        $entity = $em->getRepository('MediashareGalleryBundle:Category')->find($id);
        $response = new JsonResponse(
            array(
                'render' => $this->renderView('MediashareGalleryBundle:Gallery:sub.html.twig', array(
                    'entity' => $entity
                )),
                'id' => $id,
                'lastId' => ($entity->getParent() ? $entity->getParent()->getId() : null)
            )
        );
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }
}
