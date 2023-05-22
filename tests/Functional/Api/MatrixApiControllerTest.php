<?php

namespace App\Tests\Functional\Api;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;

class MatrixApiControllerTest extends WebTestCase
{
    public function testAddAlternative()
    {
        dd(123);
        $client = self::createClient();

        $response = $client->request(
            method: Request::METHOD_POST,
            uri: '/api/matrix/add-alternative',
            content: json_encode([
                'test' => 1,
            ]),
        );

        dd($response);
    }
}
