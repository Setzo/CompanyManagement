<?php

namespace CompanyManagementBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use CompanyManagementBundle\Entity\Role;
use CompanyManagementBundle\Form\RoleType;

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

        RoleType::setContainer($this->container);
        $em = $this->getDoctrine()->getManager();

        $roles = $em->getRepository('CompanyManagementBundle:Role')->findAll();

        return $this->render('CompanyManagementBundle:Role:index.html.twig', array(
            'roles' => $roles,
        ));
    }

    /**
     * Creates a new Role entity.
     *
     */
    public function newAction(Request $request) {

        $role = new Role();
        RoleType::setContainer($this->container);

        $form = $this->createForm('CompanyManagementBundle\Form\RoleType', $role);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $allowedActions = array();
            foreach ($form->getIterator() as $key => $item) {

                if ($key == 'title' || $key == 'description' || $key == 'name') {
                    continue;
                }
                if($item->getViewData()) {
                    $allowedActions[] = $key;
                }
            }

            $role->setAllowedActions(serialize($allowedActions));

            $em = $this->getDoctrine()->getManager();
            $em->persist($role);
            $em->flush();

            return $this->redirectToRoute('role_show', array('id' => $role->getId()));
        }

        return $this->render('CompanyManagementBundle:Role:new.html.twig', array(
            'role' => $role,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Role entity.
     *
     */
    public function showAction(Role $role) {

        RoleType::setContainer($this->container);
        $deleteForm = $this->createDeleteForm($role);

        return $this->render('CompanyManagementBundle:Role:show.html.twig', array(
            'role' => $role,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Role entity.
     *
     */
    public function editAction(Request $request, Role $role) {

        RoleType::setContainer($this->container);
        $deleteForm = $this->createDeleteForm($role);
        $editForm = $this->createForm('CompanyManagementBundle\Form\RoleType', $role);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {

            $allowedActions = array();
            foreach ($editForm->getIterator() as $key => $item) {

                if ($key == 'title' || $key == 'description' || $key == 'name') {
                    continue;
                }
                if($item->getViewData()) {
                    $allowedActions[] = $key;
                }
            }

            $role->setAllowedActions(serialize($allowedActions));


            $em = $this->getDoctrine()->getManager();
            $em->persist($role);
            $em->flush();

            return $this->redirectToRoute('role_edit', array('id' => $role->getId()));
        }

        return $this->render('CompanyManagementBundle:Role:edit.html.twig', array(
            'role' => $role,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Role entity.
     *
     */
    public function deleteAction(Request $request, Role $role) {

        RoleType::setContainer($this->container);
        $form = $this->createDeleteForm($role);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($role);
            $em->flush();
        }

        return $this->redirectToRoute('role_index');
    }

    /**
     * Creates a form to delete a Role entity.
     *
     * @param Role $role The Role entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Role $role) {

        RoleType::setContainer($this->container);

        return $this->createFormBuilder()
            ->setAction($this->generateUrl('role_delete', array('id' => $role->getId())))
            ->setMethod('DELETE')
            ->getForm();
    }
}
