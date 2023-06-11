<?php

namespace App\Fixtures;

use App\Entity\Characteristic;
use App\Entity\Type;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class CharacteristicFixtures extends Fixture implements DependentFixtureInterface
{
    public const REF_PAYLOAD_MASS = 'ref_payload_mass';
    public const REF_AIRSPEED = 'ref_airspeed';
    public const REF_FLIGHT_ALTITUDE = 'ref_flight_altitude';

    public function load(ObjectManager $manager)
    {
        foreach ($this->getData() as $data) {
            $characteristic = new Characteristic();

            /** @var Type $type */
            $type = $this->getReference($data['type']);

            $characteristic->setName($data['name']);
            $characteristic->setMultiple($data['multiple']);
            $characteristic->setType($type);

            $this->addReference($data['reference'], $characteristic);

            $manager->persist($characteristic);
        }

        $manager->flush();
    }

    private function getData(): array
    {
        return [
            [
                'reference' => self::REF_PAYLOAD_MASS,
                'name' => 'Масса полезной нагрузки, кг',
                'type' => CharacteristicTypeFixtures::REF_TYPE_INT,
                'multiple' => false,
            ],
            [
                'reference' => self::REF_AIRSPEED,
                'name' => 'Скорость  полета, км/ч',
                'type' => CharacteristicTypeFixtures::REF_TYPE_INT,
                'multiple' => false,
            ],
            [
                'reference' => self::REF_FLIGHT_ALTITUDE,
                'name' => 'Минимальная высота полета, м',
                'type' => CharacteristicTypeFixtures::REF_TYPE_INT,
                'multiple' => false,
            ],
        ];
    }

    public function getDependencies(): array
    {
        return [
            CharacteristicTypeFixtures::class,
        ];
    }
}
