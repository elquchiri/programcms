<?php


namespace ProgramCms\CategoryBundle\Repository;

use ProgramCms\CategoryBundle\Entity\CategoryEntityText;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CategoryEntityText>
 *
 * @method CategoryEntityText|null find($id, $lockMode = null, $lockVersion = null)
 * @method CategoryEntityText|null findOneBy(array $criteria, array $orderBy = null)
 * @method CategoryEntityText[]    findAll()
 * @method CategoryEntityText[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategoryEntityTextRepository extends ServiceEntityRepository
{

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CategoryEntityText::class);
    }

    public function save(CategoryEntityText $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(CategoryEntityText $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
