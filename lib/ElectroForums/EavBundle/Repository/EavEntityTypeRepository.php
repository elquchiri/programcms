<?php


namespace ElectroForums\EavBundle\Repository;

use ElectroForums\EavBundle\Entity\EavEntityType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<EavEntityType>
 *
 * @method EavEntityType|null find($id, $lockMode = null, $lockVersion = null)
 * @method EavEntityType|null findOneBy(array $criteria, array $orderBy = null)
 * @method EavEntityType[]    findAll()
 * @method EavEntityType[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EavEntityTypeRepository extends ServiceEntityRepository
{

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EavEntityType::class);
    }

    public function save(EavEntityType $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(EavEntityType $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
