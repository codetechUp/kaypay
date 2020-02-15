<?php

namespace App\Repository;

use App\Entity\Transactions;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Transactions|null find($id, $lockMode = null, $lockVersion = null)
 * @method Transactions|null findOneBy(array $criteria, array $orderBy = null)
 * @method Transactions[]    findAll()
 * @method Transactions[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TransactionsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Transactions::class);
    }
   
    public function getPartPart($id,$debut=[],$fin=[])
    {
        if(empty($debut)){
            $data1=$this->createQueryBuilder('t')
            ->select('t.id','t.dateEnvoi','t.partPdepot')
            ->Where('t.compteEmetteur = :id ')
            ->setParameter('id', $id)
            ->getQuery()
            ->getResult()
        ;
        $data2=$this->createQueryBuilder('t')
            ->select('t.id','t.dateEnvoi','t.pRetrait')
            ->Where('t.compteRecept = :id ')
            ->setParameter('id', $id)
            ->getQuery()
            ->getResult()
        ;
        return array_merge($data1,$data2);

    }else{
        $data1=$this->createQueryBuilder('t')
        ->select('t.id','t.dateEnvoi','t.partPdepot')
        ->Where('t.compteEmetteur = :id ')
        ->andWhere('t.dateEnvoi >= :debut ')
        ->andWhere('t.dateEnvoi <= :fin ')
        ->setParameter('id', $id)
        ->setParameter('fin', $fin)
        ->setParameter('debut', $debut)
        ->getQuery()
        ->getResult()
    ;
    $data2=$this->createQueryBuilder('t')
        ->select('t.id','t.dateEnvoi','t.pRetrait')
        ->Where('t.compteRecept = :id ')
        ->andWhere('t.dateEnvoi >= :debut ')
        ->andWhere('t.dateEnvoi <= :fin ')
        ->setParameter('id', $id)
        ->setParameter('fin', $fin)
        ->setParameter('debut', $debut)
        ->getQuery()
        ->getResult()
    ;
    return array_merge($data1,$data2);
    }
    }

    public function findPart($a,$debut=[],$fin=[])
    {
        if(empty($debut)){
            return $this->createQueryBuilder('t')
            ->select('t.id','t.part'.ucfirst($a),'t.dateEnvoi')
            ->getQuery()
            ->getResult()
        ;
    }else{
        return $this->createQueryBuilder('t')
        ->Where('t.dateEnvoi >= :debut ')
        ->andWhere('t.dateEnvoi <= :fin ')
        ->select('t.id','t.part'.ucfirst($a),'t.dateEnvoi')
        ->setParameter('fin', $fin)
        ->setParameter('debut', $debut)
        ->getQuery()
        ->getResult();
    }



    }
       
    /*{
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }*/
    /*
    public function findOneBySomeField($value): ?Transactions
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
