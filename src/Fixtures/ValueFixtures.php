<?php

namespace App\Fixtures;

use App\Entity\Cell;
use App\Entity\Value;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ValueFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        foreach ($this->getData() as $data) {
            $value = new Value();

            /** @var Cell $cell */
            $cell = $this->getReference($data['cell']);

            $value->setCell($cell);
            $value->setValue($data['value']);

            $manager->persist($value);
        }

        $manager->flush();
    }

    private function getData(): array
    {
        return [
            [
                'cell' => MatrixFixtures::REF_MATRIX_BPLA
                    . AlternativeFixtures::REF_ALT_MART_MK_II
                    . CharacteristicFixtures::REF_PAYLOAD_MASS,
                'value' => 25,
            ],
            [
                'cell' => MatrixFixtures::REF_MATRIX_BPLA
                    . AlternativeFixtures::REF_ALT_CHACAL_2
                    . CharacteristicFixtures::REF_PAYLOAD_MASS,
                'value' => 20,
            ],
            [
                'cell' => MatrixFixtures::REF_MATRIX_BPLA
                    . AlternativeFixtures::REF_ALT_MARULA
                    . CharacteristicFixtures::REF_PAYLOAD_MASS,
                'value' => 35,
            ],
            [
                'cell' => MatrixFixtures::REF_MATRIX_BPLA
                    . AlternativeFixtures::REF_ALT_MIRACH_26
                    . CharacteristicFixtures::REF_PAYLOAD_MASS,
                'value' => 35,
            ],
            [
                'cell' => MatrixFixtures::REF_MATRIX_BPLA
                    . AlternativeFixtures::REF_ALT_CRECERELLE
                    . CharacteristicFixtures::REF_PAYLOAD_MASS,
                'value' => 37,
            ],
            [
                'cell' => MatrixFixtures::REF_MATRIX_BPLA
                    . AlternativeFixtures::REF_ALT_LUNA_X_2000
                    . CharacteristicFixtures::REF_PAYLOAD_MASS,
                'value' => 3,
            ],

            [
                'cell' => MatrixFixtures::REF_MATRIX_BPLA
                    . AlternativeFixtures::REF_ALT_MART_MK_II
                    . CharacteristicFixtures::REF_AIRSPEED,
                'value' => 220,
            ],
            [
                'cell' => MatrixFixtures::REF_MATRIX_BPLA
                    . AlternativeFixtures::REF_ALT_CHACAL_2
                    . CharacteristicFixtures::REF_AIRSPEED,
                'value' => 320,
            ],
            [
                'cell' => MatrixFixtures::REF_MATRIX_BPLA
                    . AlternativeFixtures::REF_ALT_MARULA
                    . CharacteristicFixtures::REF_AIRSPEED,
                'value' => 280,
            ],
            [
                'cell' => MatrixFixtures::REF_MATRIX_BPLA
                    . AlternativeFixtures::REF_ALT_MIRACH_26
                    . CharacteristicFixtures::REF_AIRSPEED,
                'value' => 220,
            ],
            [
                'cell' => MatrixFixtures::REF_MATRIX_BPLA
                    . AlternativeFixtures::REF_ALT_CRECERELLE
                    . CharacteristicFixtures::REF_AIRSPEED,
                'value' => 240,
            ],
            [
                'cell' => MatrixFixtures::REF_MATRIX_BPLA
                    . AlternativeFixtures::REF_ALT_LUNA_X_2000
                    . CharacteristicFixtures::REF_AIRSPEED,
                'value' => 70,
            ],

            [
                'cell' => MatrixFixtures::REF_MATRIX_BPLA
                    . AlternativeFixtures::REF_ALT_MART_MK_II
                    . CharacteristicFixtures::REF_FLIGHT_ALTITUDE,
                'value' => 30,
            ],
            [
                'cell' => MatrixFixtures::REF_MATRIX_BPLA
                    . AlternativeFixtures::REF_ALT_CHACAL_2
                    . CharacteristicFixtures::REF_FLIGHT_ALTITUDE,
                'value' => 30,
            ],
            [
                'cell' => MatrixFixtures::REF_MATRIX_BPLA
                    . AlternativeFixtures::REF_ALT_MARULA
                    . CharacteristicFixtures::REF_FLIGHT_ALTITUDE,
                'value' => 300,
            ],
            [
                'cell' => MatrixFixtures::REF_MATRIX_BPLA
                    . AlternativeFixtures::REF_ALT_MIRACH_26
                    . CharacteristicFixtures::REF_FLIGHT_ALTITUDE,
                'value' => 150,
            ],
            [
                'cell' => MatrixFixtures::REF_MATRIX_BPLA
                    . AlternativeFixtures::REF_ALT_CRECERELLE
                    . CharacteristicFixtures::REF_FLIGHT_ALTITUDE,
                'value' => 300,
            ],
            [
                'cell' => MatrixFixtures::REF_MATRIX_BPLA
                    . AlternativeFixtures::REF_ALT_LUNA_X_2000
                    . CharacteristicFixtures::REF_FLIGHT_ALTITUDE,
                'value' => 250,
            ],
        ];
    }

    public function getDependencies(): array
    {
        return [
            CellFixtures::class,
        ];
    }
}
