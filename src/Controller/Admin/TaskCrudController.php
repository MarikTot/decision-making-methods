<?php

namespace App\Controller\Admin;

use App\Entity\Matrix;
use App\Entity\Task;
use App\Enum\UserRole;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Option\SortOrder;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted(UserRole::USER)]
class TaskCrudController extends BaseCrudController
{
    public function __construct(
        private AdminUrlGenerator $adminUrlGenerator,
    ) {
    }

    public static function getEntityFqcn(): string
    {
        return Task::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Задача')
            ->setEntityLabelInPlural('Задачи')
            ->setPageTitle(Crud::PAGE_EDIT, 'Редактирование задачи')
            ->setPageTitle(Crud::PAGE_INDEX, 'Задачи')
            ->setPageTitle(Crud::PAGE_NEW, 'Добавление задачи')
            ->setPageTitle(
                Crud::PAGE_DETAIL,
                fn(Task $task) => sprintf('Задача #%s', $task->getId()),
            )
            ->setDefaultSort(['id' => SortOrder::DESC])
        ;
    }
//
//    public function configureActions(Actions $actions): Actions
//    {
//        $actions = parent::configureActions($actions);
//
//        $newMatrix = Action::new('newMatrix', 'Создать матрицу', 'fa fa-plus')
//            ->linkToRoute('matrix_new', function (Task $task) {
//                return [
//                    'task' => $task->getId(),
//                ];
//            })
//        ;
//
//        return $actions
//            ->add(Crud::PAGE_INDEX, $newMatrix)
//        ;
//    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('title', 'Название'),
            TextareaField::new('description', 'Описание'),
            AssociationField::new('matrix', 'Матрица'),
        ];
    }
}
