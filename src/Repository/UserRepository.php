<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository implements PasswordUpgraderInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function upgradePassword(UserInterface $user, string $newHashedPassword): void
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', \get_class($user)));
        }

        $user->setPassword($newHashedPassword);
        $this->_em->persist($user);
        $this->_em->flush();
    }

    // /**
    //  * @return User[] Returns an array of User objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */


    public function findOneBySomeField($value): ?User
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }


//    public function findByRoleThatSucksLess(string $role)
//    {
//        $teachers = $this->createQueryBuilder('qsdf')
//            ->select('t.username')
//            ->from('App\Entity\User', 't')
//            ->where('t.roles LIKE :role')
//            ->setParameter('role', '%ROLE_ADMIN%')
//            ->getQuery()
//            ->getResult();
//    }
//    public function findByRoleThatSucksLess(string $role)
//    {
//        // The ResultSetMapping maps the SQL result to entities
//        $rsm = $this->createResultSetMappingBuilder('s');
//
//        $rawQuery = sprintf(
//            'SELECT %s
//                    FROM user s
//                    WHERE s.roles::jsonb ?? :role',
//            $rsm->generateSelectClause()
//        );
//
//        $query = $this->getEntityManager()->createNativeQuery($rawQuery, $rsm);
//        $query->setParameter('role', $role);
//        return $query->getResult();
//    }



//    public function findByRoleThatSucksLess(string $role)
//    {
//        $role = mb_strtoupper($role);
//
//        return $this->createQueryBuilder('u')
//            ->andWhere('JSON_CONTAINS(u.roles, :role) = 1')
//            ->setParameter('role', '"DOCTOR_ROLE"')
//            ->getQuery()
//            ->getResult();
//    }
}
