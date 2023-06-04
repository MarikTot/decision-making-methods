<?php

namespace App\Controller\Api;

use App\Dto\CharacteristicDto;
use App\Dto\CellDto;
use App\Dto\ConditionDto;
use App\Dto\ResultDto;
use App\Dto\MatrixRowDto;
use App\Entity\Cell;
use App\Service\Matrix\MatrixService;
use App\Service\MatrixSolver\MatrixSolverService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/matrix', 'api_matrix_')]
class MatrixApiController extends BaseApiController
{
    public function __construct(
        private MatrixService $matrixService,
        private MatrixSolverService $solverService,
    ) {
    }

    #[Route(
        path: '/add-alternative',
        name: 'add-alternative',
        methods: [Request::METHOD_POST],
    )]
    public function addAlternative(Request $request): Response
    {
        $data = json_decode($request->getContent(), true);

        $dto = $this->matrixService->addAlternative($data['id'], $data['alternativeId']);

        $row = new MatrixRowDto($dto->getAlternative(), $dto->getCells());

        return $this->response(
            data: $row->toArray(),
        );
    }

    #[Route(
        path: '/remove-alternative',
        name: 'remove-alternative',
        methods: [Request::METHOD_POST],
    )]
    public function removeAlternative(Request $request): Response
    {
        $data = json_decode($request->getContent(), true);

        $this->matrixService->removeAlternative($data['id'], $data['alternativeId']);

        return $this->response(
            data: [
                'success' => true,
            ],
        );
    }

    #[Route(
        path: '/add-characteristic',
        name: 'add-characteristic',
        methods: [Request::METHOD_POST],
    )]
    public function addCharacteristic(Request $request): Response
    {
        $data = json_decode($request->getContent(), true);

        $dto = $this->matrixService->addCharacteristic($data['id'], $data['characteristicId']);

        return $this->response(
            data: [
                'cells' => array_map(fn (Cell $cell) => (new CellDto($cell))->toArray(), $dto->getCells()),
                'characteristic' => (new CharacteristicDto($dto->getCharacteristic()))->toArray(),
            ],
        );
    }

    #[Route(
        path: '/remove-characteristic',
        name: 'remove-characteristic',
        methods: [Request::METHOD_POST],
    )]
    public function removeCharacteristic(Request $request): Response
    {
        $data = json_decode($request->getContent(), true);

        $this->matrixService->removeCharacteristic($data['id'], $data['characteristicId']);

        return $this->response(
            data: [
                'success' => true,
            ],
        );
    }

    #[Route(
        path: '/save-value',
        name: 'save-value',
        methods: [Request::METHOD_POST],
    )]
    public function saveValue(Request $request): Response
    {
        $data = json_decode($request->getContent(), true);

        $this->matrixService->saveValue($data['cellId'], $data['value']);

        return $this->response(
            data: ['success' => true],
        );
    }

    #[Route(
        path: '/save-condition',
        name: 'save-condition',
        methods: [Request::METHOD_POST],
    )]
    public function saveCondition(Request $request): Response
    {
        $data = json_decode($request->getContent(), true);

        $condition = $this->matrixService->saveCondition(
            $data['id'],
            $data['characteristicId'],
            $data['condition'],
        );

        return $this->response(
            data: (new ConditionDto($condition))->toArray(),
        );
    }

    #[Route(
        path: '/solve',
        name: 'solve',
        methods: [Request::METHOD_POST],
    )]
    public function solve(Request $request): Response
    {
        $data = json_decode($request->getContent(), true);

        $decision = $this->solverService->solve(
            $data['id'],
            $data['method'],
        );

        $dto = new ResultDto($decision);

        return $this->response(
            data: $dto->toArray(),
        );
    }
}
