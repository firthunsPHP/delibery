<?php

namespace App\Repository;

use App\Entity\Restaurante;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Query\Parameter;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Restaurante|null find($id, $lockMode = null, $lockVersion = null)
 * @method Restaurante|null findOneBy(array $criteria, array $orderBy = null)
 * @method Restaurante[]    findAll()
 * @method Restaurante[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RestauranteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Restaurante::class);
    }
// https://www.doctrine-project.org/projects/doctrine-orm/en/2.9/reference/query-builder.html#the-querybuilder
    // /**
    //  * @return Restaurante[] Returns an array of Restaurante objects
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
    public function findOneBySomeField($value): ?Restaurante
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function findByDayAndTime($dia, $hora, $idMunicipio){

        return $this->createQueryBuilder('r')
            -> join('r.horarios', 'h')
            ->join('r.municipiosReparto','m')
            ->where('m.id = :idMunicipio')
            ->andWhere('h.dia = :dia')
            ->andWhere('h.apertura <= :hora')
            ->andWhere('h.cierre >= :hora')
            ->setParameters( new ArrayCollection(
                array(
                    new Parameter( 'idMunicipio', $idMunicipio),
                    new Parameter( 'dia', $dia),
                    new Parameter( 'hora', $hora)
                )
            ))
            ->orderBy('r.id', 'ASC')
            ->getQuery()
            ->getResult();
    }

}
