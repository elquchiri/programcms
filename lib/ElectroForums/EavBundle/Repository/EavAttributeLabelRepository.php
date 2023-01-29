<?php


namespace ElectroForums\EavBundle\Repository;

use ElectroForums\EavBundle\Entity\EavAttributeLabel;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<EavAttributeLabel>
 *
 * @method EavAttributeLabel|null find($id, $lockMode = null, $lockVersion = null)
 * @method EavAttributeLabel|null findOneBy(array $criteria, array $orderBy = null)
 * @method EavAttributeLabel[]    findAll()
 * @method EavAttributeLabel[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EavAttributeLabelRepository extends ServiceEntityRepository
{

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EavAttributeLabel::class);
    }

    public function save(EavAttributeLabel $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(EavAttributeLabel $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
