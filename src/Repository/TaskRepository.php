<?php

namespace App\Repository;

use App\Entity\Project;
use App\Entity\Task;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\AbstractQuery;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Task>
 *
 * @method Task|null find($id, $lockMode = null, $lockVersion = null)
 * @method Task|null findOneBy(array $criteria, array $orderBy = null)
 * @method Task[]    findAll()
 * @method Task[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TaskRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Task::class);
    }

    public function add(Task $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Task $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function listByProjectDQL(Project $project)
    {
        $dql = "SELECT t FROM App\Entity\Task t 
                JOIN t.epic e 
                WHERE e.project = :project 
                ORDER BY t.title";
        $query = $this->getEntityManager()->createQuery($dql);
        $query->setParameter('project', $project);

        return $query->getArrayResult();
    }

    public function filter($params)
    {
        $qb = $this->createQueryBuilder('t')
            ->orderBy('t.title')
        ;
        if (isset($params['project'])) {
            $qb->join('t.epic', 'e');
            $qb->join('e.projects', 'p');
            $qb->andWhere('p.alias = :prj_alias');
            $qb->setParameter('prj_alias', $params['project']);
        }
        if (isset($params['title'])) {
            $qb->andWhere('t.title like :title');
            $qb->setParameter('title', '%' . $params['title'] . '%');
        }
        return $qb->getQuery()->execute();
    }

    public function getByUuid($uuid)
    {
        $qb = $this->createQueryBuilder('t')
            ->where('t.uuid = :uuid')
            ->setParameter('uuid', $uuid)
        ;
        return $qb->getQuery()->getOneOrNullResult(AbstractQuery::HYDRATE_ARRAY);
    }

//    /**
//     * @return Task[] Returns an array of Task objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('t.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Task
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
