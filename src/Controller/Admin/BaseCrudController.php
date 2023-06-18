<?php

namespace App\Controller\Admin;

use App\Entity\AuditableInterface;
use App\Enum\UserRole;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Dto\ActionDto;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted(UserRole::USER)]
abstract class BaseCrudController extends AbstractCrudController
{
    public function __construct(
        private Security $security,
    ) {
    }

    public function configureActions(Actions $actions): Actions
    {
        $actions
            ->add(Crud::PAGE_INDEX, Action::DETAIL)
            ->update(Crud::PAGE_INDEX, Action::NEW, function (Action $action) {
                return $action
                    ->setLabel('Добавить')
                    ->setIcon('fas fa-plus')
                ;
            })
            ->update(Crud::PAGE_INDEX, Action::EDIT, function (Action $action) {
                return $action
                    ->setLabel('Редактировать')
                    ->setIcon('fas fa-pencil')
                ;
            })
            ->update(Crud::PAGE_INDEX, Action::DELETE, function (Action $action) {
                return $action
                    ->setLabel('Удалить')
                    ->setIcon('fas fa-trash')
                ;
            })
            ->update(Crud::PAGE_EDIT, Action::SAVE_AND_CONTINUE, function (Action $action) {
                return $action
                    ->setLabel('Сохранить и продолжить редактировать')
                    ->setIcon('fas fa-floppy-disk')
                ;
            })
            ->update(Crud::PAGE_EDIT, Action::SAVE_AND_RETURN, function (Action $action) {
                return $action
                    ->setLabel('Сохранить')
                    ->setIcon('fas fa-floppy-disk')
                ;
            })
            ->update(Crud::PAGE_NEW, Action::SAVE_AND_ADD_ANOTHER, function (Action $action) {
                return $action
                    ->setLabel('Сохранить и добавить еще')
                    ->setIcon('fas fa-floppy-disk')
                ;
            })
            ->update(Crud::PAGE_NEW, Action::SAVE_AND_RETURN, function (Action $action) {
                return $action
                    ->setLabel('Сохранить')
                    ->setIcon('fas fa-floppy-disk')
                ;
            })
            ->update(Crud::PAGE_DETAIL, Action::EDIT, function (Action $action) {
                return $action
                    ->setLabel('Редактировать')
                    ->setIcon('fas fa-pencil')
                ;
            })
            ->update(Crud::PAGE_DETAIL, Action::INDEX, function (Action $action) {
                return $action
                    ->setLabel('Вернуться к списку')
                    ->setIcon('fas fa-arrow-left')
                ;
            })
            ->update(Crud::PAGE_DETAIL, Action::DELETE, function (Action $action) {
                return $action
                    ->setLabel('Удалить')
                    ->setIcon('fas fa-trash')
                ;
            })
            ->update(Crud::PAGE_INDEX, Action::DETAIL, function (Action $action) {
                return $action
                    ->setLabel('Просмотр')
                    ->setIcon('fas fa-eye')
                ;
            })
        ;

        $actionsArr = [];
        foreach ($actions->getAsDto(null)->getActions() as $page => $pageActions) {
            /** @var ActionDto $actionObj */
            foreach ($pageActions as $action => $actionObj) {
                $actionsArr[$page][] = $action;
                $security = $this->security ?? null;
                $actions->update($page, $action, function (Action $action) use ($security) {
                    return $action->displayIf(function ($entity) use ($security) {
                        if (
                            $entity instanceof AuditableInterface
                            && null !== $entity->getCreatedBy()
                            && false === in_array(UserRole::ADMIN, $security->getUser()->getRoles())
                            && $entity->getCreatedBy()->getUserIdentifier() !== $security->getUser()->getUserIdentifier()
                        ) {
                            return false;
                        }
                        return true;
                    });
                });
            }
        }

        return $actions;
    }
}
