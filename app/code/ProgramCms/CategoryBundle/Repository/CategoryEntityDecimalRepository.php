<?php


namespace ProgramCms\CategoryBundle\Repository;

use ProgramCms\CategoryBundle\Entity\CategoryEntityDecimal;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CategoryEntityDecimal>
 *
 * @method CategoryEntityDecimal|null find($id, $lockMode = null, $lockVersion = null)
 * @method CategoryEntityDecimal|null findOneBy(array $criteria, array $orderBy = null)
 * @method CategoryEntityDecimal[]    findAll()
 * @method CategoryEntityDecimal[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategoryEntityDecimalRepository extends ServiceEntityRepository
{

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CategoryEntityDecimal::class);
    }

    public function save(CategoryEntityDecimal $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(CategoryEntityDecimal $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
