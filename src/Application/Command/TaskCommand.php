<?php
namespace Application\Command;


use Application\DTO\TaskDTO;
use Application\Service\TaskService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class TaskCommand extends Command
{
    protected static $defaultName = 'task:action';
    private $taskService;

    public function __construct(TaskService $taskService)
    {
        parent::__construct();
        $this->taskService = $taskService;
    }

    protected function configure(): void
    {
        $this
            ->setDescription('Gestión de tareas (iniciar, detener, listar)')
            ->addArgument('action', InputArgument::REQUIRED, 'Acción a realizar: start, end o list')
            ->addArgument('taskName', InputArgument::OPTIONAL, 'Nombre de la tarea (solo para start y end)');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $data = new SymfonyStyle($input, $output);
        $action = $input->getArgument('action');
        $taskName = $input->getArgument('taskName');

        switch ($action) {
            case 'start':
                if (!$taskName) {
                    $data->error('Debes especificar un nombre de tarea para iniciar.');
                    return Command::FAILURE;
                }
                $this->taskService->startTask($taskName);
                $data->success("Tarea '{$taskName}' iniciada.");
                break;

            case 'end':
                if (!$taskName) {
                    $data->error('Debes especificar un nombre de tarea para detener.');
                    return Command::FAILURE;
                }

                $task = $this->taskService->isTaskActiveToday($taskName);
                if ($task) {
                    $this->taskService->stopTask($task);
                    $data->success("Tarea '{$taskName}' detenida.");
                    break;
                } else {
                    $data->error('La tarea no esta disponible para detener');
                    return Command::FAILURE;
                }

            case 'list':
                $tasks = $this->taskService->getAllTasks();
                if (empty($tasks->toArray())) {
                    $data->info('No hay tareas registradas.');
                } else {
                    $data->table(
                        ['Nombre', 'Estado', 'Inicio', 'Fin', 'Tiempo Total'],
                        array_map(function (TaskDTO $task) {
                            return [
                                $task->getName(),
                                $task->isActive() ? 'En proceso' : 'Completada',
                                $task->getStartTime() ? $task->getStartTime()->format('Y-m-d H:i:s') : 'N/A',
                                $task->getEndTime() ? $task->getEndTime()->format('Y-m-d H:i:s') : 'N/A',
                                gmdate('H:i:s', $task->getDurationTime() ?? 0),
                            ];
                        }, $tasks->toArray())
                    );
                }
                break;

            default:
                $data->error("Acción '{$action}' no reconocida. Usa 'start', 'end' o 'list'.");
                return Command::FAILURE;
        }

        return Command::SUCCESS;
    }
}