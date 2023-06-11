<?php

namespace App\Controller\Api;

use App\Controller\Admin\TaskCrudController;
use App\Dto\ResultDto;
use App\Dto\TaskDataDto;
use App\Service\Task\TaskService;
use App\Service\TaskSolver\TaskSolverService;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/task', 'api_task_')]
class TaskApiController extends BaseApiController
{
    public function __construct(
        private TaskService $taskService,
        private TaskSolverService $taskSolverService,
        private AdminUrlGenerator $adminUrlGenerator,
    ) {
    }

    #[Route(
        path: '/create',
        name: 'create',
        methods: [Request::METHOD_POST],
    )]
    public function create(Request $request): Response
    {
        $data = json_decode($request->getContent(), true);

        // todo: можно добавить ваилидацию)

        $dto = new TaskDataDto(
            $data['name'],
            $data['matrixId'],
            $data['description'],
            $data['alternativeIds'],
            $data['characteristicIds'],
            $data['conditions'],
        );

        $task = $this->taskService->createTask($dto);

        $url = $this->adminUrlGenerator
            ->setController(TaskCrudController::class)
            ->setAction(Action::DETAIL)
            ->setEntityId($task->getId())
            ->generateUrl()
        ;

        return $this->response(
            data: [
                'url' => $url,
            ],
        );
    }

    #[Route(
        path: '/make-decision',
        name: 'make-decision',
        methods: [Request::METHOD_POST],
    )]
    public function makeDecision(Request $request): Response
    {
        $data = json_decode($request->getContent(), true);

        $result = $this->taskSolverService->solve($data['id'], $data['method']);

        $dto = new ResultDto($result);

        return $this->response(
            data: [
                'result' => $dto->toArray(),
            ],
        );
    }
}
