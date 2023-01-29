<?php


namespace ElectroForums\EavBundle\Repository;

use ElectroForums\EavBundle\Entity\EavAttribute;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<EavAttribute>
 *
 * @method EavAttribute|null find($id, $lockMode = null, $lockVersion = null)
 * @method EavAttribute|null findOneBy(array $criteria, array $orderBy = null)
 * @method EavAttribute[]    findAll()
 * @method EavAttribute[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EavAttributeRepository extends ServiceEntityRepository
{

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EavAttribute::class);
    }

    public function save(EavAttribute $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(EavAttribute $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
