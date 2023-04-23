<?php

namespace App\Controller\Admin;

use App\Entity\CharacteristicTypeEnum;
use App\Enum\UserRole;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Option\SortOrder;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted(UserRole::USER)]
class CharacteristicTypeEnumCrudController extends BaseCrudController
{
    public static function getEntityFqcn(): string
    {
        return CharacteristicTypeEnum::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Значения типов')
            ->setEntityLabelInPlural('Значение типа')
            ->setPageTitle(Crud::PAGE_EDIT, 'Редактирование значения')
            ->setPageTitle(Crud::PAGE_INDEX, 'Значения типов')
            ->setPageTitle(Crud::PAGE_NEW, 'Добавление значения')
            ->setPageTitle(
                Crud::PAGE_DETAIL,
                fn(CharacteristicTypeEnum $typeEnum) => sprintf('Значение #%s', $typeEnum->getId()),
            )
            ->setDefaultSort(['id' => SortOrder::DESC])
            ;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            AssociationField::new('type', 'Тип')
                ->setQueryBuilder(function (QueryBuilder $qb) {
                    $alias = $qb->getAllAliases()[0] ?? 'entity';
                    $qb->andWhere($qb->expr()->eq($alias . '.defaultType', 'false'));
                })
            ,
            TextField::new('value', 'Значение'),
        ];
    }
}
