<?php

namespace ElectroForums\WebsiteBundle\Repository;

use ElectroForums\WebsiteBundle\Entity\WebsiteRoot;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<WebsiteRoot>
 *
 * @method WebsiteRoot|null find($id, $lockMode = null, $lockVersion = null)
 * @method WebsiteRoot|null findOneBy(array $criteria, array $orderBy = null)
 * @method WebsiteRoot[]    findAll()
 * @method WebsiteRoot[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WebsiteRootRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Website::class);
    }

    public function save(WebsiteRoot $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(WebsiteRoot $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
