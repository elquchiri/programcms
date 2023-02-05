<?php

namespace ElectroForums\ConfigBundle\Repository;

use ElectroForums\ConfigBundle\Entity\CoreConfigData;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Category>
 *
 * @method CoreConfigData|null find($id, $lockMode = null, $lockVersion = null)
 * @method CoreConfigData|null findOneBy(array $criteria, array $orderBy = null)
 * @method CoreConfigData[]    findAll()
 * @method CoreConfigData[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CoreConfigDataRepository extends ServiceEntityRepository
{

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CoreConfigData::class);
    }

    public function save(CoreConfigData $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(CoreConfigData $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * Returns an array of Customer objects
     * @return CoreConfigData
     */
    public function findDefaultCategory(): array
    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->orderBy('c.id', 'ASC')
//            ->getQuery()
//            ->getResult()
//        ;
    }
}
