<?php

namespace App\Controller\Admin;

use App\Dto\AlternativeDto;
use App\Dto\CharacteristicDto;
use App\Dto\CharacteristicTypeDto;
use App\Dto\MatrixDto;
use App\Entity\Alternative;
use App\Entity\Characteristic;
use App\Entity\CharacteristicType;
use App\Entity\Matrix;
use App\Entity\Task;
use App\Repository\AlternativeRepository;
use App\Repository\CharacteristicRepository;
use App\Repository\CharacteristicTypeRepository;
use App\Service\MatrixService;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use function Monolog\toArray;

#[Route('/matrix', 'matrix_')]
class MatrixController extends AbstractController
{
    public function __construct(
        private MatrixService $matrixService,
        private AdminUrlGenerator $adminUrlGenerator,
        private AlternativeRepository $alternatives,
        private CharacteristicRepository $characteristics,
        private CharacteristicTypeRepository $characteristicTypes,
    ) {
    }

    #[Route('/new', 'new')]
    public function new(Task $task, Request $request): Response
    {
        $matrix = $this->matrixService->create($task);

        $url = $this->adminUrlGenerator
            ->setRoute('matrix_edit', [
                'matrix' => $matrix->getId(),
            ])->generateUrl()
        ;

        return $this->redirect($url);
//        $matrixData = [];
//        $matrix->getMatrixCells()
//        /** @var Alternative $alternative */
//        foreach ($matrix->getAlternatives()->toArray() as $alternative) {
//            $columns = [];
//            /** @var Characteristic $characteristic */
//            foreach ($matrix->getCharacteristics()->toArray() as $characteristic) {
//                $columns[] = [
//                    'name' => $characteristic->getName(),
//                    'value' => $characteristic->getName(),
//                ];
//            }
//            $matrixData[] = [
//                'name' => $alternative->getName(),
//                'columns' => $columns,
//            ];
//        }
    }

    #[Route('/edit', 'edit')]
    public function edit(Matrix $matrix): Response
    {
        // todo: вынести
        $characteristicTypes = $this->characteristicTypes->findAll();
        $characteristicTypes = array_map(function (CharacteristicType $type) {
            return (new CharacteristicTypeDto($type))->toArray();
        }, $characteristicTypes);

        $alternatives = $this->alternatives->findAll();
        $alternatives = array_map(function (Alternative $alternative) {
            return (new AlternativeDto($alternative))->toArray();
        }, $alternatives);

        $characteristics = $this->characteristics->findAll();
        $characteristics = array_map(function (Characteristic $characteristic) {
            return (new CharacteristicDto($characteristic))->toArray();
        }, $characteristics);

        $matrixDto = new MatrixDto($matrix);

        return $this->render('page/matrix.html.twig', [
            'title' => 'Редактирование матрицы #' . $matrix->getId(),
            'data' => [
                'matrix' => $matrixDto->toArray(),
                'characteristicTypes' => $characteristicTypes,
                'alternatives' => $alternatives,
                'characteristics' => $characteristics,
            ]
        ]);
    }
}
