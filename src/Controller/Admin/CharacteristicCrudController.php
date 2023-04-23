<?php

namespace App\Controller\Admin;

use App\Entity\Characteristic;
use App\Enum\UserRole;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Option\SortOrder;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted(UserRole::USER)]
class CharacteristicCrudController extends BaseCrudController
{
    public static function getEntityFqcn(): string
    {
        return Characteristic::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Показатель')
            ->setEntityLabelInPlural('Показатели')
            ->setPageTitle(Crud::PAGE_EDIT, 'Редактирование показателя')
            ->setPageTitle(Crud::PAGE_INDEX, 'Показатели')
            ->setPageTitle(Crud::PAGE_NEW, 'Добавление показателя')
            ->setPageTitle(
                Crud::PAGE_DETAIL,
                fn(Characteristic $characteristic) => sprintf('Показатель #%s', $characteristic->getId()),
            )
            ->setDefaultSort(['id' => SortOrder::DESC])
        ;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('name', 'Название'),
            BooleanField::new('multiple', 'Может содержать несколько значений')
                ->renderAsSwitch(false),
            AssociationField::new('type', 'Тип'),
        ];
    }
}
