<?php

namespace App\Repository;

use App\Entity\CantidadPlatosPedido;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CantidadPlatosPedido|null find($id, $lockMode = null, $lockVersion = null)
 * @method CantidadPlatosPedido|null findOneBy(array $criteria, array $orderBy = null)
 * @method CantidadPlatosPedido[]    findAll()
 * @method CantidadPlatosPedido[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CantidadPlatosPedidoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CantidadPlatosPedido::class);
    }

    // /**
    //  * @return CantidadPlatosPedido[] Returns an array of CantidadPlatosPedido objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?CantidadPlatosPedido
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
