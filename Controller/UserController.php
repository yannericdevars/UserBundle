<?php
/**
 * @author Yann-Eric <yann-eric@live.fr>
 */
namespace DW\UserBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use DW\UserBundle\Entity\User;
use DW\UserBundle\Form\UserType;

/**
 * User controller.
 *
 */
class UserController extends Controller
{
    /**
     * Lists all User entities.
     *
     */
    public function indexAction()
    {
        $userService = $this->get("userService");
        $userService->verify($this->getRequest()->getSession()->get('userAutentif'), array('SUPER-ADMIN'));
        
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('DWUserBundle:User')->findAll();

        return $this->render('DWUserBundle:User:index.html.twig', array(
            'entities' => $entities,
        ));
    }

    /**
     * Finds and displays a User entity.
     *
     */
    public function showAction($id)
    {
        $userService = $this->get("userService");
        $userService->verify($this->getRequest()->getSession()->get('userAutentif'), array('SUPER-ADMIN')); 
        
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('DWUserBundle:User')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find User entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('DWUserBundle:User:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        ));
    }

    /**
     * Displays a form to create a new User entity.
     *
     */
    public function newAction()
    {
        $userService = $this->get("userService");
        $userService->verify($this->getRequest()->getSession()->get('userAutentif'), array('SUPER-ADMIN'));
        
        $entity = new User();
        $form   = $this->createForm(new UserType(), $entity);

        return $this->render('DWUserBundle:User:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a new User entity.
     *
     */
    public function createAction(Request $request)
    {
        $userService = $this->get("userService");
        $userService->verify($this->getRequest()->getSession()->get('userAutentif'), array('SUPER-ADMIN')); 
        
        $entity  = new User();
        $form = $this->createForm(new UserType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('user_show', array('id' => $entity->getId())));
        }

        return $this->render('DWUserBundle:User:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing User entity.
     *
     */
    public function editAction($id)
    {
        $userService = $this->get("userService");
        $userService->verify($this->getRequest()->getSession()->get('userAutentif'), array('SUPER-ADMIN'));
        
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('DWUserBundle:User')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find User entity.');
        }

        $editForm = $this->createForm(new UserType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('DWUserBundle:User:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Edits an existing User entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $userService = $this->get("userService");
        $userService->verify($this->getRequest()->getSession()->get('userAutentif'), array('SUPER-ADMIN'));
        
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('DWUserBundle:User')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find User entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new UserType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('user_edit', array('id' => $id)));
        }

        return $this->render('DWUserBundle:User:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a User entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $userService = $this->get("userService");
        $userService->verify($this->getRequest()->getSession()->get('userAutentif'), array('SUPER-ADMIN'));
        
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('DWUserBundle:User')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find User entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('user'));
    }

    private function createDeleteForm($id)
    {
        $userService = $this->get("userService");
        $userService->verify($this->getRequest()->getSession()->get('userAutentif'), array('SUPER-ADMIN'));
        
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
