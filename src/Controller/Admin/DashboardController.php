<?php

namespace App\Controller\Admin;

use App\Entity\Alternative;
use App\Entity\Characteristic;
use App\Entity\Matrix;
use App\Entity\Task;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    #[Route('/', name: 'admin')]
    public function index(): Response
    {
         return $this->render('dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Методы принятия решений')
        ;
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Главная', 'fa fa-home');
        yield MenuItem::linkToCrud('Альтернативы', 'fa fa-alt', Alternative::class);
        yield MenuItem::linkToCrud('Показатели', 'fa fa-alt', Characteristic::class);
        yield MenuItem::linkToCrud('Задачи', 'fa fa-alt', Task::class);
        yield MenuItem::linkToCrud('Матрицы', 'fa fa-alt', Matrix::class);
    }
}
