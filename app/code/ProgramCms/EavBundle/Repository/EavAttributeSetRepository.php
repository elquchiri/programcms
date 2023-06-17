<?php


namespace ProgramCms\EavBundle\Repository;

use ProgramCms\EavBundle\Entity\EavAttributeSet;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<EavAttributeSet>
 *
 * @method EavAttributeSet|null find($id, $lockMode = null, $lockVersion = null)
 * @method EavAttributeSet|null findOneBy(array $criteria, array $orderBy = null)
 * @method EavAttributeSet[]    findAll()
 * @method EavAttributeSet[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EavAttributeSetRepository extends ServiceEntityRepository
{

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EavAttributeSet::class);
    }

    public function save(EavAttributeSet $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(EavAttributeSet $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
