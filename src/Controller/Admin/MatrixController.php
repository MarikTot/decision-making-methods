<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MatrixController extends AbstractController
{
    #[Route('/public', 'matrix')]
    public function index(): Response
    {
        return $this->render('page/matrix.html.twig');
    }
}
