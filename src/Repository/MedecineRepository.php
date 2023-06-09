<?php

namespace App\Repository;

use App\Entity\Medecine;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Medecine|null find($id, $lockMode = null, $lockVersion = null)
 * @method Medecine|null findOneBy(array $criteria, array $orderBy = null)
 * @method Medecine[]    findAll()
 * @method Medecine[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MedecineRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Medecine::class);
    }

    // /**
    //  * @return Medecine[] Returns an array of Medecine objects
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
    public function findOneBySomeField($value): ?Medecine
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function countMedecines()
    {
        return $this->createQueryBuilder('r')
            ->select('count(r.id)')
            ->getQuery()
            ->getSingleScalarResult();;
    }
    public function getMedecineNames()
    {
        return $this->createQueryBuilder('d')
            ->select('d.name')
            ->getQuery()
            ->getResult();
    }

    public function getMedecinesByManufacturerAndReference($manufacturer, $reference)
    {
        $query = $this->createQueryBuilder('m')
            ->select('m');

        if ($manufacturer != null) {
            $query = $query
                ->andWhere('m.manufacturer = :val1')
                ->setParameter('val1', $manufacturer);
        }
        if ($reference != null) {
            $query = $query
                ->andWhere('m.reference = :val2')
                ->setParameter('val2', $reference);
        }
        return $query->getQuery()->getResult();
    }


}
