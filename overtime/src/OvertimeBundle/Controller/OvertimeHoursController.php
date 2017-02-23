<?php

namespace OvertimeBundle\Controller;

use OvertimeBundle\Entity\OvertimeHours;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Overtimehour controller.

 * @Route("overtimehours")
 * @Security("has_role('ROLE_USER')")
 */
class OvertimeHoursController extends Controller
{
    /**
     * Lists all overtimeHour entities.
     *
     * @Route("/", name="overtimehours_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $overtimeHours = $em
            ->getRepository('OvertimeBundle:OvertimeHours')
            ->findBy(array('user'=>$this->getUser()));

        return $this->render('overtimehours/index.html.twig', array(
            'overtimeHours' => $overtimeHours,
        ));
    }

    /**
     * Creates a new overtimeHour entity.
     *
     * @Route("/new", name="overtimehours_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $overtimeHour = new OvertimeHours();
        $overtimeHour->setUser($this->getUser());

        $form = $this->createForm('OvertimeBundle\Form\OvertimeHoursType', $overtimeHour);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($overtimeHour);
            $em->flush($overtimeHour);

            return $this->redirectToRoute('overtimehours_show', array('id' => $overtimeHour->getId()));
        }

        return $this->render('overtimehours/new.html.twig', array(
            'overtimeHour' => $overtimeHour,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a overtimeHour entity.
     *
     * @Route("/{id}", name="overtimehours_show")
     * @Method("GET")
     */
    public function showAction(OvertimeHours $overtimeHour, $id)
    {
        $deleteForm = $this->createDeleteForm($overtimeHour);
        $hours = $this->countHours($id);

        $classifiedHours = $this->get('overtime_classifier')->classify($overtimeHour);

        return $this->render('overtimehours/show.html.twig', array(
            'overtimeHour' => $overtimeHour,
            'delete_form' => $deleteForm->createView(),
            'hours' => $hours,
            'classifiedHours' => $classifiedHours,

        ));
    }

    /**
     * Displays a form to edit an existing overtimeHour entity.
     *
     * @Route("/{id}/edit", name="overtimehours_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, OvertimeHours $overtimeHour)
    {
        $deleteForm = $this->createDeleteForm($overtimeHour);
        $editForm = $this->createForm('OvertimeBundle\Form\OvertimeHoursType', $overtimeHour);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('overtimehours_edit', array('id' => $overtimeHour->getId()));
        }

        return $this->render('overtimehours/edit.html.twig', array(
            'overtimeHour' => $overtimeHour,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a overtimeHour entity.
     *
     * @Route("/{id}", name="overtimehours_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, OvertimeHours $overtimeHour)
    {
        $form = $this->createDeleteForm($overtimeHour);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($overtimeHour);
            $em->flush($overtimeHour);
        }

        return $this->redirectToRoute('overtimehours_index');
    }

    /**
     * Creates a form to delete a overtimeHour entity.
     *
     * @param OvertimeHours $overtimeHour The overtimeHour entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(OvertimeHours $overtimeHour)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('overtimehours_delete', array('id' => $overtimeHour->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    private function countHours($id)
    {
        $em = $this->getDoctrine()->getManager();

        $date1 = $em
            ->getRepository('OvertimeBundle:OvertimeHours')
            ->find($id)->getStartDate();
        $date2 = $em
            ->getRepository('OvertimeBundle:OvertimeHours')
            ->find($id)->getEndDate();
        $interval = date_diff($date1, $date2)->format('%H:%I');
        return $interval;
    }

}
