<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Enum\UserRole;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted(UserRole::ADMIN)]
class UserCrudController extends BaseCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('username', 'Username'),
            ChoiceField::new('roles', 'Роли')
                ->setChoices([
                    'Пользователь' => UserRole::USER,
                    'Студент' => UserRole::STUDENT,
                    'Преподаватель' => UserRole::TEACHER,
                    'Админ' => UserRole::ADMIN,
                ])
                ->allowMultipleChoices()
                ->renderAsBadges()
                ->autocomplete()
            ,
        ];
    }
}
