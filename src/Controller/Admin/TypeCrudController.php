<?php

namespace App\Controller\Admin;

use App\Entity\Type;
use App\Enum\UserRole;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Option\SortOrder;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted(UserRole::USER)]
class TypeCrudController extends BaseCrudController
{
    public static function getEntityFqcn(): string
    {
        return Type::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Тип')
            ->setEntityLabelInPlural('Типы')
            ->setPageTitle(Crud::PAGE_EDIT, 'Редактирование типа')
            ->setPageTitle(Crud::PAGE_INDEX, 'Типы')
            ->setPageTitle(Crud::PAGE_NEW, 'Добавление типа')
            ->setPageTitle(
                Crud::PAGE_DETAIL,
                fn(Type $type) => sprintf('Тип #%s', $type->getId()),
            )
            ->setDefaultSort(['id' => SortOrder::DESC])
            ;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('name', 'Название'),
            AssociationField::new('typeEnums', 'Варианты значения')
                ->setTemplatePath('admin/field/Type/type-enums.html.twig')
        ];
    }
}
