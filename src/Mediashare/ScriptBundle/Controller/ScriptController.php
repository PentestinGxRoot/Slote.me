<?php

namespace Mediashare\ScriptBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Mediashare\ScriptBundle\Entity\Script;
use Mediashare\ScriptBundle\Form\ScriptType;

use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\Finder\Finder;


/**
 * Script controller.
 *
 */
class ScriptController extends Controller
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
     * Creates a new Script entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Script();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('admin_script_show', array('id' => $entity->getId())));
        }

        return $this->render('MediashareScriptBundle:Script:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Script entity.
     *
     * @param Script $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Script $entity)
    {
        $form = $this->createForm(new ScriptType(), $entity, array(
            'action' => $this->generateUrl('admin_script_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Script entity.
     *
     */
    public function newAction()
    {
        $entity = new Script();
        $form   = $this->createCreateForm($entity);

        return $this->render('MediashareScriptBundle:Script:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
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

        $deleteForm = $this->createDeleteForm($id);

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

        return $this->render('MediashareScriptBundle:Script:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
            'contents' => $contents
        ));
    }

    /**
     * Displays a form to edit an existing Script entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MediashareScriptBundle:Script')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Script entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('MediashareScriptBundle:Script:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Script entity.
    *
    * @param Script $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Script $entity)
    {
        $form = $this->createForm(new ScriptType(), $entity, array(
            'action' => $this->generateUrl('admin_script_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Script entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MediashareScriptBundle:Script')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Script entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('admin_script_edit', array('id' => $id)));
        }

        return $this->render('MediashareScriptBundle:Script:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Script entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('MediashareScriptBundle:Script')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Script entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('admin_script'));
    }

    /**
     * Creates a form to delete a Script entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_script_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
