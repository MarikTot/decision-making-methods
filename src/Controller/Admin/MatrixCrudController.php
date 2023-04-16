<?php

namespace App\Controller\Admin;

use App\Entity\Matrix;
use App\Enum\UserRole;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Option\SortOrder;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted(UserRole::USER)]
class MatrixCrudController extends BaseCrudController
{
    public static function getEntityFqcn(): string
    {
        return Matrix::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Матрица')
            ->setEntityLabelInPlural('Матрицы')
            ->setPageTitle(Crud::PAGE_EDIT, 'Редактирование матрицы')
            ->setPageTitle(Crud::PAGE_INDEX, 'Матрицы')
            ->setPageTitle(Crud::PAGE_NEW, 'Добавление матрицы')
            ->setPageTitle(
                Crud::PAGE_DETAIL,
                fn(Matrix $matrix) => sprintf('Матрица #%s', $matrix->getId()),
            )
            ->setDefaultSort(['id' => SortOrder::DESC])
        ;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            AssociationField::new('alternative', 'Альтернатива'),
            AssociationField::new('characteristic', 'Показатель'),
            AssociationField::new('task', 'Задача'),
        ];
    }
}
