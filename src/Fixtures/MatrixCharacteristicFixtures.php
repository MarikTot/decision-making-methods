<?php

namespace App\Fixtures;

use App\Entity\Characteristic;
use App\Entity\Matrix;
use App\Entity\MatrixCharacteristic;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class MatrixCharacteristicFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        foreach ($this->getData() as $data) {
            $mc = new MatrixCharacteristic();

            /** @var Matrix $matrix */
            $matrix = $this->getReference($data['matrix']);
            /** @var Characteristic $characteristic */
            $characteristic = $this->getReference($data['characteristic']);

            $mc->setMatrix($matrix);
            $mc->setCharacteristic($characteristic);

            $manager->persist($mc);
        }

        $manager->flush();
    }

    private function getData(): array
    {
        return [
            [
                'matrix' => MatrixFixtures::REF_MATRIX_BPLA,
                'characteristic' => CharacteristicFixtures::REF_PAYLOAD_MASS,
            ],
            [
                'matrix' => MatrixFixtures::REF_MATRIX_BPLA,
                'characteristic' => CharacteristicFixtures::REF_AIRSPEED,
            ],
            [
                'matrix' => MatrixFixtures::REF_MATRIX_BPLA,
                'characteristic' => CharacteristicFixtures::REF_FLIGHT_ALTITUDE,
            ],
        ];
    }

    public function getDependencies(): array
    {
        return [
            CharacteristicFixtures::class,
            MatrixFixtures::class,
        ];
    }
}
