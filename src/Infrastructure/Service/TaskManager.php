<?php

namespace App\Infrastructure\Service;

use Doctrine\ORM\EntityManagerInterface;
use Domain\Entity\Task;
use Domain\Port\TaskManagerInterface;
use Domain\Repository\TaskRepositoryInterface;
use DateTime;

class TaskManager implements TaskManagerInterface
{
    /**
     * @var TaskRepositoryInterface
     */
    private $taskRepository;

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;


    public function __construct(EntityManagerInterface $entityManager,TaskRepositoryInterface $taskRepository)
    {
        $this->taskRepository = $taskRepository;
    }

    /**
     * @param string $taskName
     * @return Task
     * @throws \Exception
     */
    public function startTask(string $taskName): Task
    {
        $task = $this->isTaskActiveToday($taskName);
        if (is_null($task)) {
            $today = new DateTime();
            $task = new Task();
            $task->setName($taskName);
            $task->setIsActive(true);
            $task->setStartTime($today);
            $this->taskRepository->save($task);
        }
        return $task;
    }

    /**
     * @param Task $task
     * @return Task
     * @throws \Exception
     */
    public function stopTask(Task $task): Task
    {
        $task->setEndTime(new DateTime());
        $task->setIsActive(false);
        $this->taskRepository->save($task);

        return $task;
    }

    /**
     * @param string $taskName
     * @return Task|null
     */
    public function getTaskByName(string $taskName): ?Task
    {
        return $this->taskRepository->findByName($taskName);
    }

    /**
     * @param int $taskId
     * @return Task|null
     */
    public function getTaskById(int $taskId): ?Task
    {
        return $this->taskRepository->findById($taskId);
    }


    /**
     * @return Task[]
     */
    public function getAllTasks(): array
    {
        return $this->taskRepository->findAll();
    }

    /**
     * @param string $taskName
     * @return int
     * @throws \Exception
     */
    public function getTotalTimeForToday(string $taskName): int
    {
        $tasks = $this->taskRepository->getTodayRecordsByTaskName($taskName);
        $totalSeconds = 0;
        $dateNow = new \DateTime();
        /** @var Task $task */
        foreach ($tasks as $task) {
            $endTime = $task->getEndTime() ?: $dateNow;
            $interval = $endTime->getTimestamp() - $task->getStartTime()->getTimestamp();
            $totalSeconds += $interval;
        }

        return $totalSeconds;
    }

    /**
     * @param string $taskName
     * @return Task|null
     */
    public function isTaskActiveToday(string $taskName): ?Task
    {
        $tasks = $this->taskRepository->getTodayRecordsByTaskName($taskName);
        /** @var Task $task */
        foreach ($tasks as $task) {
            if ($task->getEndTime() === null) {
                return $task;
            }
        }
        return null;
    }
}
