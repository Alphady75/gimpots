<?php

namespace App\Repository;

use App\Entity\Questionnaire;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Questionnaire|null find($id, $lockMode = null, $lockVersion = null)
 * @method Questionnaire|null findOneBy(array $criteria, array $orderBy = null)
 * @method Questionnaire[]    findAll()
 * @method Questionnaire[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class QuestionnaireRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Questionnaire::class);
    }

    public function findByDateDesc()
    {
        return $this->createQueryBuilder('q')
            ->orderBy('q.created', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }

    public function countByActivite()
    {
        $query = $this->createQueryBuilder('q')
            ->select('q.activite as activiteFields, COUNT(q) as groupActivite')
            ->groupBy('activiteFields')
        ;

        return $query->getQuery()->getResult();
    }

    public function countByLogement()
    {
        $query = $this->createQueryBuilder('q')
            ->select('q.sitLogement as logementFields, COUNT(q) as groupLogement')
            ->groupBy('logementFields')
        ;

        return $query->getQuery()->getResult();
    }

    public function countBySitMatrimoniale()
    {
        $query = $this->createQueryBuilder('q')
            ->select('q.sitMatrimoniale as sitMatrimonialeFields, COUNT(q) as groupSitMatrimoniale')
            ->groupBy('sitMatrimonialeFields')
        ;

        return $query->getQuery()->getResult();
    }

    /**
     * Retourne le nombre de questionnaire remplis par date
     * @return void
     */
    public function countByDate()
    {
        $query = $this->createQueryBuilder('q')
            ->select('SUBSTRING(q.created, 1, 10) as dateEnregistrement, COUNT(q) as totalQuestionnaire')
            ->groupBy('dateEnregistrement')
        ;

        return $query->getQuery()->getResult();
    }

    // /**
    //  * @return Questionnaire[] Returns an array of Questionnaire objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('q')
            ->andWhere('q.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('q.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Questionnaire
    {
        return $this->createQueryBuilder('q')
            ->andWhere('q.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
