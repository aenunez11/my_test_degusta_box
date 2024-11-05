<?php

namespace Application\Collection;

use Application\DTO\TaskDTO;

class TaskCollection
{
    /**
     * @var TaskDTO[]
     */
private  $tasks = [];

    /**
     * TaskCollection constructor.
     * @param array $tasks
     */
    public function __construct(array $tasks)
    {
        $this->tasks = $tasks;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return $this->tasks;
    }

    /**
     * @return TaskDTO[]
     */
    public function getAll(): array
    {
        $groupedTasks = $this->getGroupedTasks();
        $tasksArray = [];

        foreach ($groupedTasks as $task) {
            $date = date('Y-m-d', $task['startTime']);

            if (!isset($tasksArray[$date])) {
                $tasksArray[$date] = [];
            }

            $tasksArray[$date][] = [
                'id' => $task['id'],
                'name' => $task['name'],
                'duration' => $task['totalTime'],
                'status' => $task['isActive'],
                'totalTime' => $task['totalTime'],
            ];
        }

        foreach ($tasksArray as $date => &$tasks) {
            foreach ($tasks as &$task) {
                $task['duration'] = gmdate('H:i:s', $task['duration']);
            }
        }
        return $tasksArray;
    }


    public function getTotalTasks(): int
    {
        $groupedTasks = $this->getGroupedTasks();
        return count($groupedTasks);
    }

    /**
     * @return false|string
     */
    public function getTotalTime()
    {
        $groupedTasks = $this->getGroupedTasks();
        $totalTime = 0;
        foreach ($groupedTasks as $task) {
            $totalTime += $task['totalTime'];
        }
        return gmdate('H:i:s', $totalTime);
    }

    public function getTotalTasksToday(): int
    {
        $todayTasks = $this->getGroupedTodayTasks();
        return count($todayTasks);
    }

    /**
     * @return false|string
     */
    public function getTotalTimeToday()
    {
        $todayTasks = $this->getGroupedTodayTasks();
        $totalTime = 0;
        foreach ($todayTasks as $task) {
            $totalTime += $task['totalTime'];
        }
        return gmdate('H:i:s', $totalTime);
    }




    public function getActiveTodayTasks(): array
    {
        return $this->getGroupedTasksByDate(true);
    }


    public function getGroupedTasks(): array
    {
        $groupedTasks = [];

        foreach ($this->tasks as $task) {
            $taskName = $task->getName();
            $date = date('Y-m-d', $task->getStartTime()->getTimestamp());
            $taskKey = $taskName . '_' . $date;
            if (!isset($groupedTasks[$taskKey])) {
                $groupedTasks[$taskKey] = [
                    'id' => $task->getId(),
                    'name' => $taskName,
                    'date' => $date,
                    'startTime' => $task->getStartTime()->getTimestamp(),
                    'count' => 1,
                    'totalTime' => $task->getDurationTime(),
                    'isActive' => $task->isActive(),
                ];
            } else {
                $groupedTasks[$taskKey]['count']++;
                $groupedTasks[$taskKey]['totalTime'] += $task->getDurationTime();
                if ($task->isActive()) {
                    $groupedTasks[$taskKey]['isActive'] = true;
                }
            }
        }

        usort($groupedTasks, function ($a, $b) {
            $dateComparison = strtotime($b['date']) <=> strtotime($a['date']);
            return $dateComparison === 0 ? strcmp($a['name'], $b['name']) : $dateComparison;
        });

        return $groupedTasks;
    }



    private function getGroupedTasksByDate(bool $activeOnly = false): array
    {
        $groupedTasks = [];
        $todayDate = date('Y-m-d');

        foreach ($this->tasks as $task) {
            if ($activeOnly && !$task->isActive()) {
                continue;
            }
            if (date('Y-m-d', $task->getStartTime()->getTimestamp()) === $todayDate) {
                $taskName = $task->getName();
                $startTime = $task->getStartTime()->getTimestamp();
                $endTime = $task->getEndTime() ? $task->getEndTime()->getTimestamp() : time();

                if (!isset($groupedTasks[$taskName])) {
                    $groupedTasks[$taskName] = [
                        'name' => $taskName,
                        'totalTime' => 0,
                    ];
                }
                $groupedTasks[$taskName]['totalTime'] += $endTime - $startTime;
            }
        }

        return array_values($groupedTasks);
    }

    private function getGroupedTodayTasks(): array
    {
        return $this->getGroupedTasksByDate(false);
    }
}
