<?php


namespace ProgramCms\CategoryBundle\Repository;

use ProgramCms\CategoryBundle\Entity\CategoryEntityVarchar;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CategoryEntityVarchar>
 *
 * @method CategoryEntityVarchar|null find($id, $lockMode = null, $lockVersion = null)
 * @method CategoryEntityVarchar|null findOneBy(array $criteria, array $orderBy = null)
 * @method CategoryEntityVarchar[]    findAll()
 * @method CategoryEntityVarchar[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategoryEntityVarcharRepository extends ServiceEntityRepository
{

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CategoryEntityVarchar::class);
    }

    public function save(CategoryEntityVarchar $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(CategoryEntityVarchar $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
