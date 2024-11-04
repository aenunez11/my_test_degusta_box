<?php

namespace Domain\Repository;

use Domain\Entity\Task;

interface TaskRepositoryInterface
{
    /**
     * @param Task $task
     */
    public function save(Task $task): void;

    /**
     * @param int $id
     * @return Task|null
     */
    public function findById(int $id): ?Task;

    /**
     * @param string $taskName
     * @return Task|null
     */
    public function findByName(string $taskName): ?Task;

    /**
     * @return array
     */
    public function findAll(): array;

    /**
     * @param string $taskName
     * @return array
     */
    public function getTodayRecordsByTaskName(string $taskName): array;
}
