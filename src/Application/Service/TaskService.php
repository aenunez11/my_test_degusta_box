<?php

namespace Application\Service;

use Application\Collection\TaskCollection;
use Application\DTO\TaskDTO;
use Domain\Port\TaskManagerInterface;
use Domain\Entity\Task;

class TaskService
{
    /**
     * @var TaskManagerInterface
     */
private $taskManager;

    public function __construct(TaskManagerInterface $taskManager)
    {
        $this->taskManager = $taskManager;
    }

    /**
     * @param string $taskName
     * @return TaskDTO
     */
    public function startTask(string $taskName): TaskDTO
    {
        /** @var Task $task */
        $task =  $this->taskManager->startTask($taskName);

        return new TaskDTO($task->getId(),$task->getName(), $task->isActive(), $task->getStartTime(), $task->getEndTime());
    }

    /**
     * @param Task $task
     * @return TaskDTO
     */
    public function stopTask(Task $task): TaskDTO
    {
        /** @var Task $task */
        $task =  $this->taskManager->stopTask($task);
        return new TaskDTO($task->getId(),$task->getName(), $task->isActive(), $task->getStartTime(), $task->getEndTime());
    }

    /**
     * @param int $taskId
     * @return Task
     */
    public function getTask(int $taskId): Task
    {
        return $this->taskManager->getTaskById($taskId);
    }

    /**
     * @return TaskCollection
     */
    public function getAllTasks()
    {
        $tasks = $this->taskManager->getAllTasks();
        /** @var  Task $task */
        $tasksDTO = array_map(function ($task){
            return new TaskDTO($task->getId(),$task->getName(), $task->isActive(), $task->getStartTime(), $task->getEndTime());
        },$tasks);

        return new TaskCollection($tasksDTO);
    }

    /**
     * @param $taskName
     * @return int
     */
    public function getTotalTimeForToday($taskName)
    {
        return $this->taskManager->getTotalTimeForToday($taskName);
    }

    /**
     * @param string $taskName
     * @return Task|null
     */
    public function isTaskActiveToday(string $taskName)
    {
        return $this->taskManager->isTaskActiveToday($taskName);
    }
}
