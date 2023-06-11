<?php

namespace App\Fixtures;

use App\Entity\User;
use App\Enum\UserRole;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    public const REF_USER_ADMIN = 'ref_user_admin';

    public function __construct(
        private UserPasswordHasherInterface $userPasswordHasher,
    ) {
    }

    public function load(ObjectManager $manager)
    {
        foreach ($this->getData() as $data) {
            $user = new User();

            $user->setUsername($data['username']);
            $user->setRoles($data['roles']);
            $user->setPassword($this->userPasswordHasher->hashPassword(
                $user,
                $data['password'],
            ));

            $this->addReference($data['reference'], $user);

            $manager->persist($user);
        }

        $manager->flush();
    }

    private function getData(): array
    {
        return [
            [
                'reference' => self::REF_USER_ADMIN,
                'username' => 'admin',
                'roles' => [UserRole::ADMIN],
                'password' => 'qwerty123456',
            ],
        ];
    }
}
