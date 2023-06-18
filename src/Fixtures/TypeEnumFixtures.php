<?php

namespace App\Fixtures;

use App\Entity\Type;
use App\Entity\TypeEnum;
use App\Entity\User;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class TypeEnumFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        foreach ($this->getData() as $data) {
            $enum = new TypeEnum();

            /** @var Type $type */
            $type = $this->getReference($data['type']);

            $enum->setType($type);
            $enum->setValue($data['value']);
            $enum->setCreatedAt(new DateTimeImmutable());

            /** @var User $user */
            $user = $this->getReference($data['createdBy']);

            $enum->setCreatedBy($user);

            $manager->persist($enum);
        }

        $manager->flush();
    }

    private function getData(): array
    {
        return [
            [
                'type' => CharacteristicTypeFixtures::REF_TYPE_YEAS_NO,
                'value' => 'Да',
                'createdBy' => UserFixtures::REF_USER_ADMIN,
            ],
            [
                'type' => CharacteristicTypeFixtures::REF_TYPE_YEAS_NO,
                'value' => 'Нет',
                'createdBy' => UserFixtures::REF_USER_ADMIN,
            ],
        ];
    }

    public function getDependencies(): array
    {
        return [
            CharacteristicTypeFixtures::class,
            UserFixtures::class,
        ];
    }
}
