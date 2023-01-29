<?php


namespace ElectroForums\CategoryBundle\Repository;

use ElectroForums\CategoryBundle\Entity\CategoryEntityInt;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CategoryEntityInt>
 *
 * @method CategoryEntityInt|null find($id, $lockMode = null, $lockVersion = null)
 * @method CategoryEntityInt|null findOneBy(array $criteria, array $orderBy = null)
 * @method CategoryEntityInt[]    findAll()
 * @method CategoryEntityInt[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategoryEntityIntRepository extends ServiceEntityRepository
{

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CategoryEntityInt::class);
    }

    public function save(CategoryEntityInt $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(CategoryEntityInt $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
