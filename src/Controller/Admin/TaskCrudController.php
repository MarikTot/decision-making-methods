<?php

namespace App\Controller\Admin;

use App\Dto\MatrixDto;
use App\Dto\TaskDto;
use App\Entity\Task;
use App\Enum\DecisionMakingMethod;
use App\Enum\UserRole;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Option\SortOrder;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted(UserRole::USER)]
class TaskCrudController extends BaseCrudController
{
    public function __construct(
        private AdminUrlGenerator $adminUrlGenerator,
        private Security $security,
    ) {
        parent::__construct($this->security);
    }

    public static function getEntityFqcn(): string
    {
        return Task::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Задача')
            ->setEntityLabelInPlural('Задачи')
            ->setPageTitle(Crud::PAGE_EDIT, 'Редактирование задачи')
            ->setPageTitle(Crud::PAGE_INDEX, 'Задачи')
            ->setPageTitle(Crud::PAGE_NEW, 'Добавление задачи')
            ->setPageTitle(
                Crud::PAGE_DETAIL,
                fn(Task $task) => sprintf('Задача #%s', $task->getId()),
            )
            ->setDefaultSort(['id' => SortOrder::DESC])
        ;
    }

    public function configureActions(Actions $actions): Actions
    {
        $actions = parent::configureActions($actions);

        $actions->remove(Crud::PAGE_INDEX, Action::EDIT);
        $actions->remove(Crud::PAGE_INDEX, Action::NEW);
        $actions->remove(Crud::PAGE_DETAIL, Action::EDIT);
        $actions->update(Crud::PAGE_INDEX, Action::DETAIL, function (Action $action) {
            return $action->displayIf(fn(Task $task) => true);
        });

        return $actions;
    }

    public function detail(AdminContext $context)
    {
        /** @var Task $task */
        $task = $context->getEntity()->getInstance();

        $taskDto = new TaskDto($task);

        $canCreateResult = $context->getUser()->getUserIdentifier() === $task->getCreatedBy()->getUserIdentifier()
            || in_array(UserRole::ADMIN, $context->getUser()->getRoles());

        return $this->render('admin/page/task-detail.html.twig', [
            'ea' => $context,
            'task' => $taskDto->toArray(),
            'resultData' => [
                'task' => $taskDto->toArray(),
                'methods' => DecisionMakingMethod::getList(),
                'canCreate' => $canCreateResult,
            ],
            'originalMatrixData' => [
                'matrix' => $taskDto->getOriginalMatrix()->toArray(),
                'showCheckboxes' => false,
            ],
            'matrixData' => [
                'matrix' => $taskDto->getMatrix()->toArray(),
                'showCheckboxes' => false,
            ],
        ]);
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('title', 'Название')
                ->formatValue(function (string $value, Task $task) {
                    $url = $this->adminUrlGenerator
                        ->setController(self::class)
                        ->setAction(Action::DETAIL)
                        ->setEntityId($task->getId())
                        ->generateUrl();
                    return sprintf('<a href="%s">%s</a>', $url, $value);
                }),
            TextareaField::new('description', 'Описание'),
            AssociationField::new('matrix', 'Матрица'),
        ];
    }
}
