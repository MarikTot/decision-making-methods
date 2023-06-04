<?php

namespace App\Controller\Admin;

use App\Entity\MatrixCharacteristic;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;

class MatrixCharacteristicCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return MatrixCharacteristic::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            AssociationField::new('matrix'),
            AssociationField::new('characteristic'),
        ];
    }
}
