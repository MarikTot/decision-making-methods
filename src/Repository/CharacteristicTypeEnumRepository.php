<?php

namespace App\Repository;

use App\Entity\CharacteristicTypeEnum;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CharacteristicTypeEnum>
 *
 * @method CharacteristicTypeEnum|null find($id, $lockMode = null, $lockVersion = null)
 * @method CharacteristicTypeEnum|null findOneBy(array $criteria, array $orderBy = null)
 * @method CharacteristicTypeEnum[]    findAll()
 * @method CharacteristicTypeEnum[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CharacteristicTypeEnumRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CharacteristicTypeEnum::class);
    }

    public function save(CharacteristicTypeEnum $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(CharacteristicTypeEnum $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return CharacteristicTypeEnum[] Returns an array of CharacteristicTypeEnum objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?CharacteristicTypeEnum
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
