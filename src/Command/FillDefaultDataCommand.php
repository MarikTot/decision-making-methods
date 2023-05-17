<?php

namespace App\Command;

use App\Entity\CharacteristicType;
use App\Entity\CharacteristicTypeEnum;
use App\Entity\User;
use App\Enum\UserRole;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

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
        private UserPasswordHasherInterface $userPasswordHasher,
    ){
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        try {
            $this->fillTypesData($output);
            $this->fillUsersData($output);
            return Command::SUCCESS;
        } catch (Exception $e) {
            $output->writeln($e->getMessage());
            return Command::FAILURE;
        }
    }

    private function fillTypesData(OutputInterface $output): void
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

            $output->writeln('Добавлен новый тип ' . $type->getName());

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

    private function fillUsersData(OutputInterface $output): void
    {
        $data = [
            [
                'username' => 'admin',
                'roles' => [UserRole::ADMIN],
                'password' => 'qwerty123456',
            ],
        ];

        foreach ($data as $userData) {
            $user = new User();

            $user->setUsername($userData['username']);
            $user->setRoles($userData['roles']);
            $user->setPassword($this->userPasswordHasher->hashPassword(
                $user,
                $userData['password'],
            ));

            $output->writeln('Добавлен новый пользователь ' . $user->getUsername());

            $this->em->persist($user);
        }

        $this->em->flush();
    }
}
