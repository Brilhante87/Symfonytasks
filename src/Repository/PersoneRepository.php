<?php

namespace App\Repository;

use App\Entity\Persone;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Persone>
 *
 * @method Persone|null find($id, $lockMode = null, $lockVersion = null)
 * @method Persone|null findOneBy(array $criteria, array $orderBy = null)
 * @method Persone[]    findAll()
 * @method Persone[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PersoneRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Persone::class);
    }

    public function save(Persone $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Persone $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @return Persone[] Returns an array of Persone objects
     */
    public function findPersonesByAgeInterval($ageMin, $ageMax): array
    {
        return $this->createQueryBuilder('p')
        ->andWhere('p.age >= :ageMin AND p.age <= :ageMax')
        ->setParameters(['ageMin'=>$ageMin, 'ageMax'=>$ageMax])

        ->getQuery()
        ->getResult()
        ;
    
    }
    public function statsPersonesByAgeInterval($ageMin, $ageMax): array
    {
      return $this->createQueryBuilder('p')
        -> select(select: 'avg(p.age) as ageMoyen, count(p.id) as nombrePersone') 
        ->andWhere('p.age >= :ageMin AND p.age <= :ageMax')
        ->setParameters(['ageMin'=>$ageMin, 'ageMax'=>$ageMax])
        ->getQuery()
        ->getScalarResult()
        ;
    
    }
   

            

//    public function findOneBySomeField($value): ?Persone
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
