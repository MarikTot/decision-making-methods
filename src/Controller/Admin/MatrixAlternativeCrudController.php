<?php

namespace App\Controller\Admin;

use App\Entity\MatrixAlternative;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;

class MatrixAlternativeCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return MatrixAlternative::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            AssociationField::new('matrix'),
            AssociationField::new('alternative'),
        ];
    }
}
