<?php

namespace App\Controller\Admin;

use App\Entity\Task;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Option\SortOrder;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class TaskCrudController extends BaseCrudController
{
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

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('title', 'Название'),
            TextEditorField::new('description', 'Описание'),
        ];
    }
}
