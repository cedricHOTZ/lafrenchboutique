<?php

namespace App\Repository;

use App\Entity\ReassuranceLeft;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ReassuranceLeft>
 *
 * @method ReassuranceLeft|null find($id, $lockMode = null, $lockVersion = null)
 * @method ReassuranceLeft|null findOneBy(array $criteria, array $orderBy = null)
 * @method ReassuranceLeft[]    findAll()
 * @method ReassuranceLeft[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReassuranceLeftRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ReassuranceLeft::class);
    }

    public function add(ReassuranceLeft $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(ReassuranceLeft $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return ReassuranceLeft[] Returns an array of ReassuranceLeft objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('r.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?ReassuranceLeft
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
