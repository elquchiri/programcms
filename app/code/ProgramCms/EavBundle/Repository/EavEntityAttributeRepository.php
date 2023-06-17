<?php


namespace ProgramCms\EavBundle\Repository;

use ProgramCms\EavBundle\Entity\EavEntityAttribute;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<EavEntityAttribute>
 *
 * @method EavEntityAttribute|null find($id, $lockMode = null, $lockVersion = null)
 * @method EavEntityAttribute|null findOneBy(array $criteria, array $orderBy = null)
 * @method EavEntityAttribute[]    findAll()
 * @method EavEntityAttribute[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EavEntityAttributeRepository extends ServiceEntityRepository
{

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EavEntityAttribute::class);
    }

    public function save(EavEntityAttribute $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(EavEntityAttribute $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
