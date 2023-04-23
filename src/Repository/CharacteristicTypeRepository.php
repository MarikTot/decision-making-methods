<?php

namespace App\Repository;

use App\Entity\CharacteristicType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CharacteristicType>
 *
 * @method CharacteristicType|null find($id, $lockMode = null, $lockVersion = null)
 * @method CharacteristicType|null findOneBy(array $criteria, array $orderBy = null)
 * @method CharacteristicType[]    findAll()
 * @method CharacteristicType[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CharacteristicTypeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CharacteristicType::class);
    }

    public function save(CharacteristicType $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(CharacteristicType $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
