<?php

namespace App\Repository;

use App\Entity\MedicalFolder;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method MedicalFolder|null find($id, $lockMode = null, $lockVersion = null)
 * @method MedicalFolder|null findOneBy(array $criteria, array $orderBy = null)
 * @method MedicalFolder[]    findAll()
 * @method MedicalFolder[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MedicalFolderRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MedicalFolder::class);
    }

    // /**
    //  * @return MedicalFolder[] Returns an array of MedicalFolder objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?MedicalFolder
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
