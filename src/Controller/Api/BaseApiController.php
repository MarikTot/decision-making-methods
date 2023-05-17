<?php

namespace App\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

abstract class BaseApiController extends AbstractController
{
    public function response(
        int $code = Response::HTTP_OK,
        array $data = [],
        array $errors = [],
        array $headers = [],
        array $context = [],
    )
    {
        return $this->json(
            [
                'status' => $code,
                'data' => $data,
                'isError' => count($errors) > 0,
                'errors' => $errors,
            ],
            $code,
            $headers,
            $context,
        );
    }
}
