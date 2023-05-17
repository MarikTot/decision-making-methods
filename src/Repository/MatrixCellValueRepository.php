<?php

namespace App\Repository;

use App\Entity\MatrixCellValue;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<MatrixCellValue>
 *
 * @method MatrixCellValue|null find($id, $lockMode = null, $lockVersion = null)
 * @method MatrixCellValue|null findOneBy(array $criteria, array $orderBy = null)
 * @method MatrixCellValue[]    findAll()
 * @method MatrixCellValue[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MatrixCellValueRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MatrixCellValue::class);
    }

    public function save(MatrixCellValue $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(MatrixCellValue $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return MatrixCellValue[] Returns an array of MatrixCellValue objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('m.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?MatrixCellValue
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
