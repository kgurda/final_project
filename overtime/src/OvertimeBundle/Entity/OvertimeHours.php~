<?php

namespace OvertimeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * OvertimeHours
 *
 * @ORM\Table(name="overtime_hours")
 * @ORM\Entity(repositoryClass="OvertimeBundle\Repository\OvertimeHoursRepository")
 */
class OvertimeHours
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="startDate", type="datetime")
     */
    private $startDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="endDate", type="datetime")
     */
    private $endDate;

    /**
     * @ORM\ManyToOne(targetEntity="OvertimeBundle\Entity\User", inversedBy="overtimeHours")
     */
    private $user;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set startDate
     *
     * @param \DateTime $startDate
     * @return OvertimeHours
     */
    public function setStartDate($startDate)
    {
        $this->startDate = $startDate;

        return $this;
    }

    /**
     * Get startDate
     *
     * @return \DateTime 
     */
    public function getStartDate()
    {
        return $this->startDate;
    }


    /**
     * Set endDate
     *
     * @param \DateTime $endDate
     * @return OvertimeHours
     */
    public function setEndDate($endDate)
    {
        $this->endDate = $endDate;

        return $this;
    }

    /**
     * Get endDate
     *
     * @return \DateTime 
     */
    public function getEndDate()
    {
        return $this->endDate;
    }

    /**
     * Set user
     *
     * @param \OvertimeBundle\Entity\User $user
     * @return OvertimeHours
     */
    public function setUser(\OvertimeBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \OvertimeBundle\Entity\User 
     */
    public function getUser()
    {
        return $this->user;
    }
}
