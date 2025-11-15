<?php

namespace App\Repository;

use App\Entity\Company;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Psr\Log\LoggerInterface;

/**
 * @extends ServiceEntityRepository<Company>
 */
class CompanyRepository extends ServiceEntityRepository
{
    private LoggerInterface $logger;

    public function __construct(ManagerRegistry $registry, LoggerInterface $logger)
    {
        parent::__construct($registry, Company::class);
        $this->logger = $logger;
    }

    public function findByMinNumberOfMembers(int $minMembers) {
        $query = $this->createQueryBuilder('c')
            ->leftJoin('c.members', 'm')
            ->groupBy('c')
            ->having('COUNT(m.id) >= :minMembers')
            ->select('c', 'COUNT(m) AS numberOfMembers')
            ->setParameter('minMembers', $minMembers)
            ->getQuery();
        $this->logger->debug('CompantRepository::findByMinNumberOfMembers called');
        $this->logger->debug('SQL query:');
        $this->logger->debug($query->getSQL());
        return $query->getResult();
    }

    //    /**
    //     * @return Company[] Returns an array of Company objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('c.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Company
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
