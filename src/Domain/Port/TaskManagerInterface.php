<?php

namespace Domain\Port;

use Domain\Entity\Task;

interface TaskManagerInterface
{
    /**
     * @param string $taskName
     * @return Task
     */
    public function startTask(string $taskName): Task;

    /**
     * @param Task $task
     * @return Task
     */
    public function stopTask(Task $task): Task;

    /**
     * @param string $taskName
     * @return Task|null
     */
    public function getTaskByName(string $taskName): ?Task;

    /**
     * @param int $taskId
     * @return Task|null
     */
    public function getTaskById(int $taskId): ?Task;

    /**
     * @return Task[]
     */
    public function getAllTasks(): array;

    /**
     * @param string $taskName
     * @return int
     */
    public function getTotalTimeForToday(string $taskName): int;

    /**
     * @param string $taskName
     * @return Task|null
     */
    public function isTaskActiveToday(string $taskName): ?Task;
}
