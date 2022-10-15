<?php

namespace App\Infrastructure\Doctrine\Repository;

use App\Domain\Core\Entity\Project;
use App\Domain\Core\Entity\Space;
use App\Domain\Core\Repository\ProjectRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Project>
 *
 * @method Project|null find($id, $lockMode = null, $lockVersion = null)
 * @method Project|null findOneBy(array $criteria, array $orderBy = null)
 * @method Project[]    findAll()
 * @method Project[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProjectRepository extends ServiceEntityRepository implements ProjectRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Project::class);
    }

    public function add(Project $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Project $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function listTaskCountBySpace(Space $space)
    {
        $dql = "SELECT p as project, COUNT(t) as taskCount, AVG(t) as taskAvg
            FROM App\Entity\Project p 
            JOIN p.epics e
            JOIN e.tasks t
            WHERE p.space = :space
            GROUP BY p.id
            ORDER BY COUNT(t) DESC
        ";
        $query = $this->getEntityManager()->createQuery($dql);
        $query->setParameter('space', $space);

        return $query->execute();
    }

    public function listTaskCountBySpaceQueryBuilder(Space $space)
    {
        $qb = $this->createQueryBuilder('p')
            ->select(['p as project', 'COUNT(t) as taskCount', 'AVG(t) as taskAvg'])
            ->join('p.epics', 'e')
            ->join('e.tasks', 't')
            ->where('p.space = :space')
            ->groupBy('p.id')
            ->orderBy('taskCount', 'DESC')
            ->setParameter('space', $space);
        ;
        return $qb->getQuery()->execute();
    }

    public function listBySpaceDQL(Space $space)
    {
        $dql = 'SELECT project FROM App\Entity\Project project WHERE project.space = :spc';
        $query = $this->getEntityManager()->createQuery($dql);
        $query->setParameter('spc', $space);

        return $query->getArrayResult();
    }

    public function listBySpaceQueryBuilder(Space $space)
    {
        $qb = $this->createQueryBuilder('p')
            ->where('p.space = :space')
            ->setParameter('space', $space);
        ;
        return $qb->getQuery()->execute();
    }

    public function filter($filter)
    {
        $qb = $this->createQueryBuilder('prj')
            ->select('prj, s, up, u')
            ->join('prj.space', 's')
            ->join('prj.userProjects', 'up')
            ->join('up.user', 'u')
            ->orderBy('prj.name')
        ;
        if (isset($filter['space'])) {
            $qb->andWhere('s.uuid = :space');
            $qb->setParameter('space', $filter['space']);
        }
        if (isset($filter['user'])) {
            $qb->andWhere('u.username = :username');
            $qb->setParameter('username', $filter['user']);
        }
        return $qb->getQuery()->execute();
    }

    public function getByUuid($uuid)
    {
        $dql = "SELECT p FROM App\Entity\Project p WHERE p.uuid = :uuid";
        $query = $this->getEntityManager()->createQuery($dql);
        $query->setParameter('uuid', $uuid);

        return $query->getArrayResult();
    }

//    /**
//     * @return Project[] Returns an array of Project objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Project
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
