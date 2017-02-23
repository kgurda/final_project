<?php

namespace OvertimeBundle\Controller;

use OvertimeBundle\Entity\User;
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
        /** @var User $user */
        $user = $this->getUser();

        if ($user->hasRole('ROLE_ADMIN')) {
            return $this->redirectToRoute('overtime_admin_index');
        } elseif ($user->hasRole('ROLE_USER')) {
            return $this->redirectToRoute('overtimehours_index');
        }

    }
}
