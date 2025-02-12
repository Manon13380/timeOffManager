<?php

namespace App\Repository;

use App\Entity\User;
use App\Entity\LeaveRequest;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<LeaveRequest>
 */
class LeaveRequestRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LeaveRequest::class);
    }

    public function findAllByUserId(int $userId)
    {
        return $this->createQueryBuilder('lr')
            ->andWhere('lr.userName = :userId')
            ->setParameter('userId', $userId)
            ->orderBy('lr.startDate', 'ASC')
            ->getQuery()
            ->getResult();
    }

    //    /**
    //     * @return LeaveRequest[] Returns an array of LeaveRequest objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('l')
    //            ->andWhere('l.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('l.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?LeaveRequest
    //    {
    //        return $this->createQueryBuilder('l')
    //            ->andWhere('l.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
