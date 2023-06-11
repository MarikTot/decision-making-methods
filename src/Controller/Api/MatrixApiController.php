<?php

namespace App\Controller\Api;

use App\Service\Matrix\MatrixService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/matrix', 'api_matrix_')]
class MatrixApiController extends BaseApiController
{
    public function __construct(
        private MatrixService $matrixService,
    ) {
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
}
