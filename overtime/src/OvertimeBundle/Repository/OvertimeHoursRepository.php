<?php

namespace OvertimeBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * OvertimeHoursRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class OvertimeHoursRepository extends EntityRepository
{
    public function countHours($id)
    {
        $date1 = $this
            ->getEntityManager()
            ->createQuery("
        SELECT b.startDate
        FROM OvertimeBundle:OvertimeHours b
        WHERE b.id = :id
        ")
            ->setParameter('id', $id)->getResult();

        return $date1;

    }
}
