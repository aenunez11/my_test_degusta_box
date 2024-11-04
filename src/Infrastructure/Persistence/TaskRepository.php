<?php

namespace App\Infrastructure\Persistence;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Domain\Entity\Task;
use Domain\Repository\TaskRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;


class TaskRepository extends ServiceEntityRepository implements TaskRepositoryInterface
{
    private $entityManager;

    public function __construct(ManagerRegistry $registry,EntityManagerInterface $entityManager)
    {
        parent::__construct($registry, Task::class);
        $this->entityManager = $entityManager;
    }

    /**
     * @param Task $task
     */
    public function save(Task $task): void
    {
        $this->entityManager->persist($task);
        $this->entityManager->flush();
    }

    /**
     * @param int $id
     * @return Task|null
     */
    public function findById(int $id): ?Task
    {
        return $this->entityManager->getRepository(Task::class)->find($id);
    }

    /**
     * @param string $taskName
     * @return Task|null
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findByName(string $taskName): ?Task
    {

        return $this->createQueryBuilder('t')
            ->andWhere('t.name = :name')
            ->setParameter('name', $taskName)
            ->getQuery()
            ->getOneOrNullResult();
    }

    /**
     * @return Task[]
     */
    public function findAll(): array
    {
        return $this->entityManager->getRepository(Task::class)->findAll();
    }

    /**
     * @param string $taskName
     * @return array
     * @throws \Exception
     */
    public function getTodayRecordsByTaskName(string $taskName): array
    {
        $today = new \DateTime();
        $today->setTime(0, 0);

        return $this->createQueryBuilder('t')
            ->where('t.name = :name')
            ->andWhere('t.startTime >= :today')
            ->setParameter('name', $taskName)
            ->setParameter('today', $today)
            ->getQuery()
            ->getResult();
    }

}
