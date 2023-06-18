<?php

namespace App\Controller\Admin;

use App\Entity\Alternative;
use App\Entity\Characteristic;
use App\Entity\Type;
use App\Entity\TypeEnum;
use App\Entity\Matrix;
use App\Entity\Task;
use App\Entity\User;
use App\Enum\UserRole;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\UserMenu;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

class DashboardController extends AbstractDashboardController
{
    public function __construct(
        private AdminUrlGenerator $adminUrlGenerator,
    ) {
    }

    #[Route('/', name: 'admin')]
    public function index(): Response
    {
         return $this->render('dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Задачи принятия решений')
        ;
    }

    public function configureUserMenu(UserInterface $user): UserMenu
    {
        $profileUrl = $this->adminUrlGenerator
            ->setController(UserCrudController::class)
            ->setAction('profile')
            ->setEntityId($user->getUserIdentifier())
            ->generateUrl()
        ;
        return parent::configureUserMenu($user)
            ->setName((string) $user)
            ->setMenuItems([
                MenuItem::linkToUrl(
                    'Личный кабинет',
                    'fa fa-user', $profileUrl,
                ),
                MenuItem::linkToUrl(
                    'Выйти',
                    'fa fa-arrow-right-from-bracket', $this->generateUrl('app_logout'),
                ),
            ])
        ;
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Методы принятия решений', 'fa fa-home');

        yield MenuItem::section('Основное', 'fa fa-list')
            ->setPermission(UserRole::ADMIN)
        ;

        yield MenuItem::linkToCrud('Типы оценок по показателям', 'fa fa-alt', Type::class)
            ->setPermission(UserRole::USER)
        ;

        yield MenuItem::linkToCrud('Значения типов', 'fa fa-alt', TypeEnum::class)
            ->setPermission(UserRole::USER)
        ;

        yield MenuItem::linkToCrud('Альтернативы', 'fa fa-alt', Alternative::class)
            ->setPermission(UserRole::USER)
        ;
        yield MenuItem::linkToCrud('Показатели', 'fa fa-alt', Characteristic::class)
            ->setPermission(UserRole::USER)
        ;
        yield MenuItem::linkToCrud('Матрицы', 'fa fa-alt', Matrix::class)
            ->setPermission(UserRole::USER)
        ;
//        yield MenuItem::linkToCrud('Связь матриц с альтернативами', 'fa fa-alt', MatrixAlternative::class)
//            ->setPermission(UserRole::USER)
//        ;
//        yield MenuItem::linkToCrud('Связь матриц с показателями', 'fa fa-alt', MatrixCharacteristic::class)
//            ->setPermission(UserRole::USER)
//        ;
        yield MenuItem::linkToCrud('Задачи', 'fa fa-alt', Task::class)
            ->setPermission(UserRole::USER)
        ;

        yield MenuItem::section('Администрирование', 'fa fa-gear')
            ->setPermission(UserRole::ADMIN)
        ;

        yield MenuItem::linkToCrud('Пользователи', 'fa fa-user', User::class)
            ->setPermission(UserRole::ADMIN)
        ;
    }
}
