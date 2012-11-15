<?php

/**
 * @author Yann-Eric <yann-eric@live.fr>
 */

namespace DW\UserBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use DW\UserBundle\Entity\Role;
use DW\UserBundle\Form\RoleType;

/**
 * Role controller.
 *
 */
class RoleController extends Controller {

    /**
     * Lists all Role entities.
     *
     */
    public function indexAction() {
        $userService = $this->get("userService");
        $userService->verify($this->getRequest()->getSession()->get('userAutentif'), array('SUPER-ADMIN'));

        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('DWUserBundle:Role')->findAll();

        return $this->render('DWUserBundle:Role:index.html.twig', array(
                    'entities' => $entities,
                ));
    }

    /**
     * Finds and displays a Role entity.
     *
     */
    public function showAction($id) {
        $userService = $this->get("userService");
        $userService->verify($this->getRequest()->getSession()->get('userAutentif'), array('SUPER-ADMIN'));

        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('DWUserBundle:Role')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Role entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('DWUserBundle:Role:show.html.twig', array(
                    'entity' => $entity,
                    'delete_form' => $deleteForm->createView(),));
    }

    /**
     * Displays a form to create a new Role entity.
     *
     */
    public function newAction() {
        $userService = $this->get("userService");
        $userService->verify($this->getRequest()->getSession()->get('userAutentif'), array('SUPER-ADMIN'));

        $entity = new Role();
        $form = $this->createForm(new RoleType(), $entity);

        return $this->render('DWUserBundle:Role:new.html.twig', array(
                    'entity' => $entity,
                    'form' => $form->createView(),
                ));
    }

    /**
     * Creates a new Role entity.
     *
     */
    public function createAction(Request $request) {

        $userService = $this->get("userService");
        $userService->verify($this->getRequest()->getSession()->get('userAutentif'), array('SUPER-ADMIN'));

        $entity = new Role();
        $form = $this->createForm(new RoleType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('role_show', array('id' => $entity->getId())));
        }

        return $this->render('DWUserBundle:Role:new.html.twig', array(
                    'entity' => $entity,
                    'form' => $form->createView(),
                ));
    }

    /**
     * Displays a form to edit an existing Role entity.
     *
     */
    public function editAction($id) {
        $userService = $this->get("userService");
        $userService->verify($this->getRequest()->getSession()->get('userAutentif'), array('SUPER-ADMIN'));


        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('DWUserBundle:Role')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Role entity.');
        }

        $editForm = $this->createForm(new RoleType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('DWUserBundle:Role:edit.html.twig', array(
                    'entity' => $entity,
                    'edit_form' => $editForm->createView(),
                    'delete_form' => $deleteForm->createView(),
                ));
    }

    /**
     * Edits an existing Role entity.
     *
     */
    public function updateAction(Request $request, $id) {
        $userService = $this->get("userService");
        $userService->verify($this->getRequest()->getSession()->get('userAutentif'), array('SUPER-ADMIN'));

        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('DWUserBundle:Role')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Role entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new RoleType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('role_edit', array('id' => $id)));
        }

        return $this->render('DWUserBundle:Role:edit.html.twig', array(
                    'entity' => $entity,
                    'edit_form' => $editForm->createView(),
                    'delete_form' => $deleteForm->createView(),
                ));
    }

    /**
     * Deletes a Role entity.
     *
     */
    public function deleteAction(Request $request, $id) {
        $userService = $this->get("userService");
        $userService->verify($this->getRequest()->getSession()->get('userAutentif'), array('SUPER-ADMIN'));

        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('DWUserBundle:Role')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Role entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('role'));
    }

    private function createDeleteForm($id) {
        $userService = $this->get("userService");
        $userService->verify($this->getRequest()->getSession()->get('userAutentif'), array('SUPER-ADMIN'));

        return $this->createFormBuilder(array('id' => $id))
                        ->add('id', 'hidden')
                        ->getForm()
        ;
    }

}
