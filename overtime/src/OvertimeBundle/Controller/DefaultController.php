<?php

namespace OvertimeBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/")
     * @Security("has_role('ROLE_USER')")
     */
    public function indexAction()
    {
        return $this->redirectToRoute('overtimehours_index');
    }
}
