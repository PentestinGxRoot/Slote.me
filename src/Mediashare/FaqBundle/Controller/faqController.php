<?php

namespace Mediashare\FaqBundle\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Mediashare\FaqBundle\Entity\faq;
use Mediashare\FaqBundle\Form\faqType;

/**
 * faq controller.
 *
 */
class faqController extends Controller
{

    /**
     * Lists all faq entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('MediashareFaqBundle:faq')->findBy(array(), array('position'=>'ASC'));

        return $this->render('MediashareFaqBundle:faq:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new faq entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new faq();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('admin_faq_show', array('id' => $entity->getId())));
        }

        return $this->render('MediashareFaqBundle:faq:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a faq entity.
     *
     * @param faq $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(faq $entity)
    {
        $form = $this->createForm(new faqType(), $entity, array(
            'action' => $this->generateUrl('admin_faq_create'),
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
     * Displays a form to create a new faq entity.
     *
     */
    public function newAction()
    {
        $entity = new faq();
        $form   = $this->createCreateForm($entity);

        return $this->render('MediashareFaqBundle:faq:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a faq entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MediashareFaqBundle:faq')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find faq entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('MediashareFaqBundle:faq:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing faq entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MediashareFaqBundle:faq')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find faq entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('MediashareFaqBundle:faq:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a faq entity.
    *
    * @param faq $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(faq $entity)
    {
        $form = $this->createForm(new faqType(), $entity, array(
            'action' => $this->generateUrl('admin_faq_update', array('id' => $entity->getId())),
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
     * Edits an existing faq entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MediashareFaqBundle:faq')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find faq entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('admin_faq_show', array('id' => $id)));
        }

        return $this->render('MediashareFaqBundle:faq:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a faq entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('MediashareFaqBundle:faq')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find faq entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('admin_faq'));
    }

    /**
     * Creates a form to delete a faq entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_faq_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit',
                array(
                    'label' => 'Supprimer',
                    'attr' => array('class' => 'btn btn-danger')
                ))
            ->getForm()
        ;
    }

    public function sortAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $value = $request->get('value');
        /** @var Faq $entity */
        $entity = $em->getRepository('MediashareFaqBundle:Faq')->find($id);
        $entity->setPosition($value);
        $em->persist($entity);
        $em->flush();
        return new JsonResponse(array('result' => 'OK'));
    }
}
