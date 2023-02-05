<?php

namespace App\Repository;

use App\Entity\Article;
use App\Data\SearchData;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;

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
    /**
     * @var PaginatorInterface
     */
    private $paginator;

    public function __construct(ManagerRegistry $registry, PaginatorInterface $paginator)
    {
        parent::__construct($registry, Article::class);
        $this->paginator = $paginator;
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
     * @return PaginationInterface
     * 
     */
    public function findSearch(SearchData $search): PaginationInterface
    {
            
        $query = $this->getSearchQuery($search)->getQuery();
        return $this->paginator->paginate(
            $query,
            $search->page,
            6
        );

    }

    /**
     * Récupère le prix minimum et maximum correspondant à une recherche
     * @return interger[]
     */
    public function findMinMax(SearchData $search): array
    {
        $result = $this->getSearchQuery($search, true)
            ->select('MIN(a.price) as min', 'MAX(a.price) as max')
            ->getQuery()
            ->getScalarResult();
        return [(int)$result[0]['min'], (int)$result[0]['max']];
    }

    private function getSearchQuery (SearchData $search, $ignorePrice = false): QueryBuilder
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

        if(!empty($search->min) && $ignorePrice === false) {
            $query = $query
            ->andWhere('a.price >= :min')
            ->setParameter('min', $search->min);
        }

        if(!empty($search->max) && $ignorePrice === false) {
            $query = $query
            ->andWhere('a.price <= :max')
            ->setParameter('max', $search->max);
        }

        /* if(!empty($search->categories)) {
            $query = $query
                ->andWhere('c.id IN (:categories)')
                ->setParameter('categories', $search->categories);
        } */
        ;
        return $query;
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
