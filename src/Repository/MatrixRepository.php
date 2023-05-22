<?php

namespace App\Repository;

use App\Entity\Matrix;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Matrix>
 *
 * @method Matrix|null find($id, $lockMode = null, $lockVersion = null)
 * @method Matrix|null findOneBy(array $criteria, array $orderBy = null)
 * @method Matrix[]    findAll()
 * @method Matrix[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MatrixRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Matrix::class);
    }

    public function save(Matrix $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Matrix $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
