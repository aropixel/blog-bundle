<?php

namespace Aropixel\BlogBundle\Repository;

use Aropixel\AdminBundle\Repository\PublishableRepository;
use Aropixel\BlogBundle\Entity\Post;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Post|null find($id, $lockMode = null, $lockVersion = null)
 * @method Post|null findOneBy(array $criteria, array $orderBy = null)
 * @method Post[]    findAll()
 * @method Post[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PostRepository extends PublishableRepository
{
    public function __construct(ManagerRegistry $registry, string $className = Post::class)
    {
        parent::__construct($registry, $className);
    }

    public function findPrevious(Post $post, bool $loop = false): ?Post
    {
        $qb = $this->qbPublished('p');
        $previous = $qb
            ->andWhere('p.createdAt < :date')
            ->orderBy('p.createdAt', 'DESC')
            ->setParameter('date', $post->getCreatedAt())
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult()
        ;

        if (null === $previous && $loop) {
            $previous = $this->getLast();
        }

        return $previous;
    }

    public function findNext(Post $post, bool $loop = false): ?Post
    {
        $qb = $this->qbPublished('p');
        $next = $qb
            ->andWhere('p.createdAt > :date')
            ->orderBy('p.createdAt', 'ASC')
            ->setParameter('date', $post->getCreatedAt())
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult()
        ;

        if (null === $next && $loop) {
            $next = $this->getFirst();
        }

        return $next;
    }

    /**
     * @return Post[]|null
     */
    public function findNextSiblings(Post $post, int $quantity = 10): ?array
    {
        $qb = $this->qbPublished('p');

        return $qb
            ->andWhere('p.createdAt > :date')
            ->orderBy('p.createdAt', 'ASC')
            ->setParameter('date', $post->getCreatedAt())
            ->setMaxResults($quantity)
            ->getQuery()
            ->getResult()
        ;
    }

    public function getFirst(): ?Post
    {
        $qb = $this->qbPublished('p');

        /** @var Post[] $posts */
        $posts = $qb
            ->orderBy('p.createdAt', 'ASC')
            ->getQuery()
            ->getResult()
        ;

        return current($posts);
    }

    public function getLast(): ?Post
    {
        $qb = $this->qbPublished('p');

        /** @var Post[] $posts */
        $posts = $qb
            ->orderBy('p.createdAt', 'ASC')
            ->getQuery()
            ->getResult()
        ;

        return end($posts);
    }

    public function add(Post $post, bool $flush = false): void
    {
        $this->getEntityManager()->persist($post);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Post $post, bool $flush = false): void
    {
        $this->getEntityManager()->remove($post);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
