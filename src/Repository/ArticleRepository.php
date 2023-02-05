<?php

namespace App\Repository;

use App\Data\SearchData;
use App\Entity\Article;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Article>
 *
 * @method Article|null find($id, $lockMode = null, $lockVersion = null)
 * @method Article|null findOneBy(array $criteria, array $orderBy = null)
 * @method Article[]    findAll()
 * @method Article[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArticleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Article::class);
    }

    public function save(Article $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Article $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findByPopularity(): array
    {
        return $this->createQueryBuilder('a')
            ->orderBy('a.popularity', 'DESC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * 
     * Récupère les articles en lien avec une recherche
     * @return Article[]
     * 
     */
    public function findSearch(SearchData $search): array
    {
        $query = $this
            ->createQueryBuilder('a')
            ->select('c', 'a')
            ->join('a.categories', 'c');

        if(!empty($search->q)) {
            $query = $query
                ->andWhere('a.title LIKE :q')
                ->orWhere('a.description LIKE :q')
                ->setParameter('q', "%{$search->q}%");
        }

        if(!empty($search->min)) {
            $query = $query
            ->andWhere('a.price >= :min')
            ->setParameter('min', $search->min);
        }

        if(!empty($search->max)) {
            $query = $query
            ->andWhere('a.price <= :max')
            ->setParameter('max', $search->max);
        }

        if(!empty($search->categories)) {
            $query = $query
                ->andWhere('c.id IN :categories')
                ->setParameter('categories', $search->categories);
        }
        ;
            
        return $query->getQuery()->getResult();
    }

//    /**
//     * @return Article[] Returns an array of Article objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('a.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Article
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
