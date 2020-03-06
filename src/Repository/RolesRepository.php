<?php

namespace App\Repository;

use App\Entity\Roles;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Roles|null find($id, $lockMode = null, $lockVersion = null)
 * @method Roles|null findOneBy(array $criteria, array $orderBy = null)
 * @method Roles[]    findAll()
 * @method Roles[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RolesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Roles::class);
    }
    public function findByLibelle($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.libelle = :val')
            ->setParameter('val', $value)
            ->setMaxResults(1)
            ->getQuery()
            ->getResult()
        ;
    }
    public function roleForAS()
    {
        return $this->createQueryBuilder('r')
        ->select('r.id','r.libelle')
            ->Where('r.libelle != :as')
            ->andWhere('r.libelle  !=:pa')
            ->andWhere('r.libelle !=:pu')
            ->setParameter('as', 'ROLE_ADMIN_SYST')
            ->setParameter('pu', 'ROLE_PADMIN')
            ->setParameter('pa','ROLE_PUSER')
            ->getQuery()
            ->getResult()
        ;
    }  public function roleForA()
    {
        return $this->createQueryBuilder('r')
            ->select('r.id','r.libelle')
            ->Where('r.libelle = :pa ')
            ->setParameter('pa', 'ROLE_CAISSIER')
            ->getQuery()
            ->getResult()
        ;
    }
    public function roleForP()
    {
        return $this->createQueryBuilder('r')
        ->select('r.id','r.libelle')
            ->Where('r.libelle = :as OR r.libelle  = :pa')
            ->setParameter('as', 'ROLE_PUSER')
            ->setParameter('pa', 'ROLE_PADMIN')
            ->getQuery()
            ->getResult()
        ;
    }
    public function roleForPA()
    {
        return $this->createQueryBuilder('r')
        ->select('r.id','r.libelle')
            ->Where('r.libelle = :as ')
            ->setParameter('as', 'ROLE_PUSER')
            ->getQuery()
            ->getResult()
        ;
    }

    // /**
    //  * @return Roles[] Returns an array of Roles objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Roles
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
