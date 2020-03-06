<?php

namespace App\Repository;

use App\Entity\Users;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Users|null find($id, $lockMode = null, $lockVersion = null)
 * @method Users|null findOneBy(array $criteria, array $orderBy = null)
 * @method Users[]    findAll()
 * @method Users[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UsersRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Users::class);
    }
    public function getLast()
    {
        return $this->createQueryBuilder('u')
            ->orderBy('u.id', 'DESC')
            ->setMaxResults(1)
            ->getQuery()
            ->getResult()
        ;
    }
    public function getUsersForAS($role)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.role != :as')
            ->setParameter('as', $role)
            ->getQuery()
            ->getResult()
        ;
    } public function getUsersForA($a,$b)
    {
        return $this->createQueryBuilder('u')
        ->andWhere('u.role != :as AND u.role != :a')
        ->setParameter('as',$a)
            ->setParameter('a', $b)
            ->getQuery()
            ->getResult()
        ;
    }public function getUsersForP($p,$pu)
    {
        $a="ROLE_PUSER";
        $b="ROLE_PADMIN";
        return $this->createQueryBuilder('u')
            ->andWhere('u.role = :as OR u.role = :a')
            
            
            ->setParameter('as',$a)
            ->setParameter('a', $b)

            ->getQuery()
            ->getResult()
        ;
    }
    public function getUsersForPA($p,$r)
    {
        return $this->createQueryBuilder('u')
            ->Where('u.role = :as')
            ->andWhere('u.partenaire  =:pa')
            ->setParameter('pa', $p)
            ->setParameter('as',$r)
            ->getQuery()
            ->getResult()
        ;
    }


    // /**
    //  * @return Users[] Returns an array of Users objects
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

    /*
    public function findOneBySomeField($value): ?Users
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
