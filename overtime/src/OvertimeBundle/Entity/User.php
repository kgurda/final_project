<?php
// src/AppBundle/Entity/User.php

namespace OvertimeBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints\DateTime;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\OneToMany(targetEntity="OvertimeBundle\Entity\OvertimeHours", mappedBy="user")
     */
    private $overtimeHours;

    public function __construct()
    {
        parent::__construct();

        $this->roles = array('ROLE_USER');
        $this->overtimeHours = new ArrayCollection();
    }

    /**
     * Add overtimeHours
     *
     * @param \OvertimeBundle\Entity\OvertimeHours $overtimeHours
     * @return User
     */
    public function addOvertimeHour(\OvertimeBundle\Entity\OvertimeHours $overtimeHours)
    {
        $this->overtimeHours[] = $overtimeHours;

        return $this;
    }

    /**
     * Remove overtimeHours
     *
     * @param \OvertimeBundle\Entity\OvertimeHours $overtimeHours
     */
    public function removeOvertimeHour(\OvertimeBundle\Entity\OvertimeHours $overtimeHours)
    {
        $this->overtimeHours->removeElement($overtimeHours);
    }

    /**
     * Get overtimeHours
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getOvertimeHours()
    {
        return $this->overtimeHours;
    }
}
