<?php

namespace App\Controller\Admin;

use App\Entity\Alternative;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Option\SortOrder;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class AlternativeCrudController extends BaseCrudController
{
    public static function getEntityFqcn(): string
    {
        return Alternative::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Альтернатива')
            ->setEntityLabelInPlural('Альтернативы')
            ->setPageTitle(Crud::PAGE_EDIT, 'Редактирование альтернативы')
            ->setPageTitle(Crud::PAGE_INDEX, 'Альтернативы')
            ->setPageTitle(Crud::PAGE_NEW, 'Добавление альтернативы')
            ->setPageTitle(
                Crud::PAGE_DETAIL,
                fn(Alternative $alternative) => sprintf('Альтернатива #%s', $alternative->getId()),
            )
            ->setDefaultSort(['id' => SortOrder::DESC])
        ;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('name', 'Название'),
            DateTimeField::new('createdAt', 'Дата создания')->hideOnForm(),
        ];
    }
}
