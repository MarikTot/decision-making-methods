<?php

namespace App\Fixtures;

use App\Entity\Alternative;
use App\Entity\Cell;
use App\Entity\Characteristic;
use App\Entity\Matrix;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class CellFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        foreach ($this->getData() as $data) {
            $cell = new Cell();

            /** @var Matrix $matrix */
            $matrix = $this->getReference($data['matrix']);
            /** @var Alternative $alternative */
            $alternative = $this->getReference($data['alternative']);
            /** @var Characteristic $characteristic */
            $characteristic = $this->getReference($data['characteristic']);

            $cell->setMatrix($matrix);
            $cell->setAlternative($alternative);
            $cell->setCharacteristic($characteristic);

            $this->addReference($data['reference'], $cell);

            $manager->persist($cell);
        }

        $manager->flush();
    }

    private function getData(): array
    {
        return [
            [
                'reference' => MatrixFixtures::REF_MATRIX_BPLA
                    . AlternativeFixtures::REF_ALT_MART_MK_II
                    . CharacteristicFixtures::REF_PAYLOAD_MASS,
                'matrix' => MatrixFixtures::REF_MATRIX_BPLA,
                'alternative' => AlternativeFixtures::REF_ALT_MART_MK_II,
                'characteristic' => CharacteristicFixtures::REF_PAYLOAD_MASS,
            ],
            [
                'reference' => MatrixFixtures::REF_MATRIX_BPLA
                    . AlternativeFixtures::REF_ALT_CHACAL_2
                    . CharacteristicFixtures::REF_PAYLOAD_MASS,
                'matrix' => MatrixFixtures::REF_MATRIX_BPLA,
                'alternative' => AlternativeFixtures::REF_ALT_CHACAL_2,
                'characteristic' => CharacteristicFixtures::REF_PAYLOAD_MASS,
            ],
            [
                'reference' => MatrixFixtures::REF_MATRIX_BPLA
                    . AlternativeFixtures::REF_ALT_MARULA
                    . CharacteristicFixtures::REF_PAYLOAD_MASS,
                'matrix' => MatrixFixtures::REF_MATRIX_BPLA,
                'alternative' => AlternativeFixtures::REF_ALT_MARULA,
                'characteristic' => CharacteristicFixtures::REF_PAYLOAD_MASS,
            ],
            [
                'reference' => MatrixFixtures::REF_MATRIX_BPLA
                    . AlternativeFixtures::REF_ALT_MIRACH_26
                    . CharacteristicFixtures::REF_PAYLOAD_MASS,
                'matrix' => MatrixFixtures::REF_MATRIX_BPLA,
                'alternative' => AlternativeFixtures::REF_ALT_MIRACH_26,
                'characteristic' => CharacteristicFixtures::REF_PAYLOAD_MASS,
            ],
            [
                'reference' => MatrixFixtures::REF_MATRIX_BPLA
                    . AlternativeFixtures::REF_ALT_CRECERELLE
                    . CharacteristicFixtures::REF_PAYLOAD_MASS,
                'matrix' => MatrixFixtures::REF_MATRIX_BPLA,
                'alternative' => AlternativeFixtures::REF_ALT_CRECERELLE,
                'characteristic' => CharacteristicFixtures::REF_PAYLOAD_MASS,
            ],
            [
                'reference' => MatrixFixtures::REF_MATRIX_BPLA
                    . AlternativeFixtures::REF_ALT_LUNA_X_2000
                    . CharacteristicFixtures::REF_PAYLOAD_MASS,
                'matrix' => MatrixFixtures::REF_MATRIX_BPLA,
                'alternative' => AlternativeFixtures::REF_ALT_LUNA_X_2000,
                'characteristic' => CharacteristicFixtures::REF_PAYLOAD_MASS,
            ],

            [
                'reference' => MatrixFixtures::REF_MATRIX_BPLA
                    . AlternativeFixtures::REF_ALT_MART_MK_II
                    . CharacteristicFixtures::REF_AIRSPEED,
                'matrix' => MatrixFixtures::REF_MATRIX_BPLA,
                'alternative' => AlternativeFixtures::REF_ALT_MART_MK_II,
                'characteristic' => CharacteristicFixtures::REF_AIRSPEED,
            ],
            [
                'reference' => MatrixFixtures::REF_MATRIX_BPLA
                    . AlternativeFixtures::REF_ALT_CHACAL_2
                    . CharacteristicFixtures::REF_AIRSPEED,
                'matrix' => MatrixFixtures::REF_MATRIX_BPLA,
                'alternative' => AlternativeFixtures::REF_ALT_CHACAL_2,
                'characteristic' => CharacteristicFixtures::REF_AIRSPEED,
            ],
            [
                'reference' => MatrixFixtures::REF_MATRIX_BPLA
                    . AlternativeFixtures::REF_ALT_MARULA
                    . CharacteristicFixtures::REF_AIRSPEED,
                'matrix' => MatrixFixtures::REF_MATRIX_BPLA,
                'alternative' => AlternativeFixtures::REF_ALT_MARULA,
                'characteristic' => CharacteristicFixtures::REF_AIRSPEED,
            ],
            [
                'reference' => MatrixFixtures::REF_MATRIX_BPLA
                    . AlternativeFixtures::REF_ALT_MIRACH_26
                    . CharacteristicFixtures::REF_AIRSPEED,
                'matrix' => MatrixFixtures::REF_MATRIX_BPLA,
                'alternative' => AlternativeFixtures::REF_ALT_MIRACH_26,
                'characteristic' => CharacteristicFixtures::REF_AIRSPEED,
            ],
            [
                'reference' => MatrixFixtures::REF_MATRIX_BPLA
                    . AlternativeFixtures::REF_ALT_CRECERELLE
                    . CharacteristicFixtures::REF_AIRSPEED,
                'matrix' => MatrixFixtures::REF_MATRIX_BPLA,
                'alternative' => AlternativeFixtures::REF_ALT_CRECERELLE,
                'characteristic' => CharacteristicFixtures::REF_AIRSPEED,
            ],
            [
                'reference' => MatrixFixtures::REF_MATRIX_BPLA
                    . AlternativeFixtures::REF_ALT_LUNA_X_2000
                    . CharacteristicFixtures::REF_AIRSPEED,
                'matrix' => MatrixFixtures::REF_MATRIX_BPLA,
                'alternative' => AlternativeFixtures::REF_ALT_LUNA_X_2000,
                'characteristic' => CharacteristicFixtures::REF_AIRSPEED,
            ],

            [
                'reference' => MatrixFixtures::REF_MATRIX_BPLA
                    . AlternativeFixtures::REF_ALT_MART_MK_II
                    . CharacteristicFixtures::REF_FLIGHT_ALTITUDE,
                'matrix' => MatrixFixtures::REF_MATRIX_BPLA,
                'alternative' => AlternativeFixtures::REF_ALT_MART_MK_II,
                'characteristic' => CharacteristicFixtures::REF_FLIGHT_ALTITUDE,
            ],
            [
                'reference' => MatrixFixtures::REF_MATRIX_BPLA
                    . AlternativeFixtures::REF_ALT_CHACAL_2
                    . CharacteristicFixtures::REF_FLIGHT_ALTITUDE,
                'matrix' => MatrixFixtures::REF_MATRIX_BPLA,
                'alternative' => AlternativeFixtures::REF_ALT_CHACAL_2,
                'characteristic' => CharacteristicFixtures::REF_FLIGHT_ALTITUDE,
            ],
            [
                'reference' => MatrixFixtures::REF_MATRIX_BPLA
                    . AlternativeFixtures::REF_ALT_MARULA
                    . CharacteristicFixtures::REF_FLIGHT_ALTITUDE,
                'matrix' => MatrixFixtures::REF_MATRIX_BPLA,
                'alternative' => AlternativeFixtures::REF_ALT_MARULA,
                'characteristic' => CharacteristicFixtures::REF_FLIGHT_ALTITUDE,
            ],
            [
                'reference' => MatrixFixtures::REF_MATRIX_BPLA
                    . AlternativeFixtures::REF_ALT_MIRACH_26
                    . CharacteristicFixtures::REF_FLIGHT_ALTITUDE,
                'matrix' => MatrixFixtures::REF_MATRIX_BPLA,
                'alternative' => AlternativeFixtures::REF_ALT_MIRACH_26,
                'characteristic' => CharacteristicFixtures::REF_FLIGHT_ALTITUDE,
            ],
            [
                'reference' => MatrixFixtures::REF_MATRIX_BPLA
                    . AlternativeFixtures::REF_ALT_CRECERELLE
                    . CharacteristicFixtures::REF_FLIGHT_ALTITUDE,
                'matrix' => MatrixFixtures::REF_MATRIX_BPLA,
                'alternative' => AlternativeFixtures::REF_ALT_CRECERELLE,
                'characteristic' => CharacteristicFixtures::REF_FLIGHT_ALTITUDE,
            ],
            [
                'reference' => MatrixFixtures::REF_MATRIX_BPLA
                    . AlternativeFixtures::REF_ALT_LUNA_X_2000
                    . CharacteristicFixtures::REF_FLIGHT_ALTITUDE,
                'matrix' => MatrixFixtures::REF_MATRIX_BPLA,
                'alternative' => AlternativeFixtures::REF_ALT_LUNA_X_2000,
                'characteristic' => CharacteristicFixtures::REF_FLIGHT_ALTITUDE,
            ],
        ];
    }

    public function getDependencies(): array
    {
        return [
            MatrixFixtures::class,
            AlternativeFixtures::class,
            CharacteristicFixtures::class,
        ];
    }
}
