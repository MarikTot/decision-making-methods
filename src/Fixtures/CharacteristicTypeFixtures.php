<?php

namespace App\Fixtures;

use App\Entity\Type;
use App\Entity\User;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class CharacteristicTypeFixtures extends Fixture implements DependentFixtureInterface
{
    public const REF_TYPE_INT = 'ref_type_int';
    public const REF_TYPE_STRING = 'ref_type_string';
    public const REF_TYPE_FLOAT = 'ref_type_float';
    public const REF_TYPE_YEAS_NO = 'ref_type_yeas_no';

    public function load(ObjectManager $manager)
    {
        foreach ($this->getData() as $data) {
            $type = new Type();

            $type->setName($data['name']);
            $type->setIsNumber($data['isNumber']);
            $type->setDefaultType(true);
            $type->setCreatedAt(new DateTimeImmutable());

            /** @var User $user */
            $user = $this->getReference($data['createdBy']);

            $type->setCreatedBy($user);

            $this->addReference($data['reference'], $type);

            $manager->persist($type);
        }

        $manager->flush();
    }

    private function getData(): array
    {
        return [
            [
                'reference' => self::REF_TYPE_INT,
                'name' => 'Число',
                'isNumber' => true,
                'createdBy' => UserFixtures::REF_USER_ADMIN,
            ],
            [
                'reference' => self::REF_TYPE_STRING,
                'name' => 'Строка',
                'isNumber' => false,
                'createdBy' => UserFixtures::REF_USER_ADMIN,
            ],
            [
                'reference' => self::REF_TYPE_FLOAT,
                'name' => 'С плавающей точкой',
                'isNumber' => true,
                'createdBy' => UserFixtures::REF_USER_ADMIN,
            ],
            [
                'reference' => self::REF_TYPE_YEAS_NO,
                'name' => 'Да/Нет',
                'isNumber' => true,
                'createdBy' => UserFixtures::REF_USER_ADMIN,
            ],
        ];
    }

    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
        ];
    }
}
