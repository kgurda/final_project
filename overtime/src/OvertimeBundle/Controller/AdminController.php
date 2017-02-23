<?php

namespace OvertimeBundle\Controller;

use OvertimeBundle\Entity\OvertimeHours;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/admin")
 * @Security("has_role('ROLE_ADMIN')")
 */
class AdminController extends Controller
{
    /**
     * @Route("/")
     * @Security("has_role('ROLE_ADMIN')")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $users = $em->getRepository('OvertimeBundle:User')->findAll();
        return ['users' => $users];
    }

    /**
     * Lists all overtimeHour entities.
     *
     * @Route("/show/{id}")
     * @Template()
     */
    public function showAllByUserIdAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $overtimeHours = $em
            ->getRepository('OvertimeBundle:OvertimeHours')
            ->findBy(array('user'=>$id));

        return $this->render('@Overtime/Admin/showAllByUserId.html.twig', array(
            'overtimeHours' => $overtimeHours,
        ));
    }

    /**
     * Lists all overtimeHour entities.
     *
     * @Route("/show/{idU}/{idO}")
     * @Template()
     * @ParamConverter("overtimeHour", class="OvertimeBundle:OvertimeHours", options={"id"="idO"})
     */
    public function showByIdAction(OvertimeHours $overtimeHour, $idU, $idO)
    {
        $hours = $this->countHours($idO);
        $overtimeHour->setUser($this->getUser());

        $classifiedHours = $this->get('overtime_classifier')->classify($overtimeHour);

        return $this->render('@Overtime/Admin/showById.html.twig', array(
            'overtimeHour' => $overtimeHour,
            'hours' => $hours,
            'classifiedHours' => $classifiedHours,
        ));
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