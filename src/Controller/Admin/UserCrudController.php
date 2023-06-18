<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Enum\UserRole;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\KeyValueStore;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted(UserRole::USER)]
class UserCrudController extends BaseCrudController
{
    public function __construct(
        private Security $security,
        private UserPasswordHasherInterface $userPasswordHasher,
    ) {
        parent::__construct($security);
    }

    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('username', 'Логин'),
            TextField::new('password')
                ->setFormType(RepeatedType::class)
                ->setFormTypeOptions([
                    'type' => PasswordType::class,
                    'first_options' => [
                        'label' => 'Пароль',
                        'attr' => [
                            'min' => 8,
                            'max' => 100,
                        ],
                        'row_attr' => [
                            'class' => 'col-md-5 col-xxl-5',
                            'style' => 'padding-right: calc(var(--bs-gutter-x)*.5)',
                        ],
                    ],
                    'second_options' => [
                        'label' => 'Повторите пароль',
                        'attr' => [
                            'min' => 8,
                            'max' => 100,
                        ],
                        'row_attr' => [
                            'class' => 'col-md-5 col-xxl-5',
                            'style' => 'padding-right: calc(var(--bs-gutter-x)*.5)',
                        ],
                    ],
                    'mapped' => false,
                ])
                ->setRequired($pageName === Crud::PAGE_NEW)
                ->onlyOnForms(),
            TextField::new('firstname', 'Имя'),
            TextField::new('lastname', 'Фамилия'),
            ChoiceField::new('roles', 'Роли')
                ->setChoices([
                    'Пользователь' => UserRole::USER,
                    'Администратор' => UserRole::ADMIN,
                ])
                ->allowMultipleChoices()
                ->renderAsBadges()
                ->autocomplete()
            ,
        ];
    }

    public function configureActions(Actions $actions): Actions
    {
        $actions = parent::configureActions($actions);

        $actions->setPermission(Action::DETAIL, UserRole::ADMIN);
        $actions->setPermission(Action::EDIT, UserRole::ADMIN);
        $actions->setPermission(Action::NEW, UserRole::ADMIN);
        $actions->setPermission(Action::INDEX, UserRole::ADMIN);
        $actions->setPermission(Action::SAVE_AND_ADD_ANOTHER, UserRole::ADMIN);
        $actions->setPermission(Action::SAVE_AND_RETURN, UserRole::ADMIN);
        $actions->setPermission(Action::SAVE_AND_CONTINUE, UserRole::ADMIN);
        $actions->setPermission(Action::DELETE, UserRole::ADMIN);
        $actions->setPermission('profile', UserRole::USER);
        $actions->setPermission('profile', UserRole::USER);

        return $actions;
    }

    public function profile(AdminContext $context): Response
    {
        /** @var User $user */
        $user = $context->getEntity()->getInstance();

        if (
            $this->security->getUser()->getUserIdentifier() !== $user->getUserIdentifier()
            && false === in_array(UserRole::ADMIN, $this->security->getUser()->getRoles())
        ) {
            throw $this->createAccessDeniedException();
        }

        return $this->render('admin/page/profile.html.twig', [
            'title' => 'Личный кабинет',
            'user' => $user,
        ]);
    }

    public function createNewFormBuilder(EntityDto $entityDto, KeyValueStore $formOptions, AdminContext $context): FormBuilderInterface
    {
        $formBuilder = parent::createNewFormBuilder($entityDto, $formOptions, $context);
        return $this->addPasswordEventListener($formBuilder);
    }

    public function createEditFormBuilder(EntityDto $entityDto, KeyValueStore $formOptions, AdminContext $context): FormBuilderInterface
    {
        $formBuilder = parent::createEditFormBuilder($entityDto, $formOptions, $context);
        return $this->addPasswordEventListener($formBuilder);
    }

    private function addPasswordEventListener(FormBuilderInterface $formBuilder): FormBuilderInterface
    {
        return $formBuilder->addEventListener(FormEvents::POST_SUBMIT, $this->hashPassword());
    }

    private function hashPassword() {
        return function($event) {
            $form = $event->getForm();
            if (!$form->isValid()) {
                return;
            }
            $password = $form->get('password')->getData();
            if ($password === null) {
                return;
            }

            $hash = $this->userPasswordHasher->hashPassword($this->getUser(), $password);
            $form->getData()->setPassword($hash);
        };
    }
}
