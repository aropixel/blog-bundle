<?php

namespace Aropixel\BlogBundle\Repository;

use Aropixel\AdminBundle\Repository\PublishableRepository;
use Aropixel\BlogBundle\Entity\Post;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Post|null find($id, $lockMode = null, $lockVersion = null)
 * @method Post|null findOneBy(array $criteria, array $orderBy = null)
 * @method Post[]    findAll()
 * @method Post[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PostRepository extends PublishableRepository
{
    public function __construct(RegistryInterface $registry, $className)
    {
        parent::__construct($registry, $className);
    }


    public function findPrevious(Post $post, $loop=false): ?Post
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

        if (is_null($previous) && $loop) {
            $previous = $this->getLast();
        }

        return $previous;
    }


    public function findNext(Post $post, $loop=false): ?Post
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

        if (is_null($next) && $loop) {
            $next = $this->getFirst();
        }

        return $next;
    }


    public function findNexts(Post $post, $quantity=10): ?array
    {

        $qb = $this->qbPublished('p');
        $next = $qb
            ->andWhere('p.createdAt > :date')
            ->orderBy('p.createdAt', 'ASC')
            ->setParameter('date', $post->getCreatedAt())
            ->setMaxResults($quantity)
            ->getQuery()
            ->getResult()
        ;

        return $next;
    }


    public function getFirst(): ?Post
    {

        $qb = $this->qbPublished('p');

        /** @var array $posts */
        $posts = $qb
            ->orderBy('p.createdAt', 'ASC')
            ->getQuery()
            ->getResult()
        ;

        $first = current($posts);

        return $first;
    }


    public function getLast(): ?Post
    {

        $qb = $this->qbPublished('p');

        /** @var array $posts */
        $posts = $qb
            ->orderBy('p.createdAt', 'ASC')
            ->getQuery()
            ->getResult()
        ;

        $last = end($posts);

        return $last;
    }

}
