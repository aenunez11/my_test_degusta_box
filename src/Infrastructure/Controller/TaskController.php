<?php

namespace App\Infrastructure\Controller;


use Application\Service\TaskService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TaskController extends AbstractController
{
private  $taskService;

    public function __construct(TaskService $taskService)
    {
        $this->taskService = $taskService;
    }

    /**
     * Get all tasks
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getAllTasks()
    {
        $taskCollection = $this->taskService->getAllTasks();
        return $this->render('tasks/index.html.twig',[
            'taskCollection' => $taskCollection
        ]);
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function getStartTask(Request $request): Response
    {
        $parameters = $request->request->all();
        $taskName = $parameters['name'] ?? '';

        if (!$taskName) {
            return $this->returnJsonAjaxResponse(['status' => 'error', 'message' => 'Invalid task name']);
        }

        $taskDTO = $this->taskService->startTask($taskName);
        $time = $this->taskService->getTotalTimeForToday($taskName);

        return $this->returnJsonAjaxResponse([
            'status' => 'success',
            'task' => $taskDTO->getName(),
            'taskId' => $taskDTO->getId(),
            'time' => $time
        ]);
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function getEndTask(Request $request): Response
    {
        $parameters = $request->request->all();
        $taskId = $parameters['taskId'] ?? '';
        if (!$taskId) {
            return $this->returnJsonAjaxResponse(['error' => 'Task ID No found']);
        }
        $task = $this->taskService->getTask($taskId);
        if (!$task) {
            return $this->returnJsonAjaxResponse(['error' => 'Task No found']);
        }
        $stoppedTask = $this->taskService->stopTask($task);
        return $this->returnJsonAjaxResponse($stoppedTask);
    }

    /**
     * @param $value
     * @return Response
     */
    protected function returnJsonAjaxResponse($value): Response
    {
        $response = new Response();
        $response->setContent(json_encode($value, JSON_THROW_ON_ERROR));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }
}