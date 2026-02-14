<?php

namespace App\Repository;

use App\Entity\Blog;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Blog>
 */
class BlogRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Blog::class);
    }
public function searchByTitleAndDate(?string $title, ?string $date)
{
    $qb = $this->createQueryBuilder('b');

    if ($title) {
        $qb->andWhere('b.title LIKE :title')
           ->setParameter('title', '%' . $title . '%');
    }

    if ($date) {
        $start = new \DateTimeImmutable($date . ' 00:00:00');
        $end = new \DateTimeImmutable($date . ' 23:59:59');

        $qb->andWhere('b.createdAt BETWEEN :start AND :end')
           ->setParameter('start', $start)
           ->setParameter('end', $end);
    }

    $qb->orderBy('b.createdAt', 'DESC');

    return $qb->getQuery()->getResult();
}

    //    /**
    //     * @return Blog[] Returns an array of Blog objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('b')
    //            ->andWhere('b.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('b.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Blog
    //    {
    //        return $this->createQueryBuilder('b')
    //            ->andWhere('b.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
