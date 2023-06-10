<?php

namespace App\Service\Task;

use App\Dto\TaskDataDto;
use App\Entity\Task;
use App\Repository\AlternativeRepository;
use App\Repository\CharacteristicRepository;
use App\Repository\MatrixRepository;
use Doctrine\ORM\EntityManagerInterface;

class TaskService
{
    public function __construct(
        public AlternativeRepository $alternatives,
        public CharacteristicRepository $characteristics,
        public MatrixRepository $matrices,
        public EntityManagerInterface $em,
    ) {
    }

    public function createTask(TaskDataDto $dto): Task
    {
        $task = new Task();

        $task->setTitle($dto->getName());
        $task->setDescription($dto->getDescription());

        $alternatives = $this->alternatives->findBy(['id' => $dto->getAlternativeIds()]);

        foreach ($alternatives as $alternative) {
            $task->addAlternative($alternative);
        }

        $characteristics = $this->characteristics->findBy(['id' => $dto->getCharacteristicIds()]);

        foreach ($characteristics as $characteristic) {
            $task->addCharacteristic($characteristic);
        }

        $matrix = $this->matrices->find($dto->getMatrixId());

        if (null === $matrix) {
            //
            throw new \Exception();
        }

        $task->setMatrix($matrix);

        $this->em->persist($task);
        $this->em->flush();

        return $task;
    }
}
