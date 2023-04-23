<?php

namespace App\Command;

use App\Entity\CharacteristicType;
use App\Entity\CharacteristicTypeEnum;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'app:fill-data',
    description: 'Fills default data.',
    aliases: ['app:fill-default-data'],
    hidden: false
)]
class FillDefaultDataCommand extends Command
{
    public function __construct(
        private EntityManagerInterface $em,
    ){
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        try {
            $this->fillTypesData();
            return Command::SUCCESS;
        } catch (Exception $e) {
            $output->writeln($e->getMessage());
            return Command::FAILURE;
        }
    }

    private function fillTypesData(): void
    {
        $data = [
            'Число' => [],
            'Строка' => [],
            'Да/Нет' => [
                'Да',
                'Нет',
            ],
        ];

        foreach ($data as $defaultTypesData => $enums) {
            $type = new CharacteristicType();

            $type->setName($defaultTypesData);
            $type->setDefaultType(true);

            $this->em->persist($type);

            if ([] !== $enums) {
                foreach ($enums as $enum) {
                    $typeEnum = new CharacteristicTypeEnum();

                    $typeEnum->setValue($enum);
                    $typeEnum->setType($type);

                    $this->em->persist($typeEnum);
                }
            }
        }

        $this->em->flush();
    }
}
