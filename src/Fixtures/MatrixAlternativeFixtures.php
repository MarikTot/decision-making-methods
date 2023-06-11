<?php

namespace App\Fixtures;

use App\Entity\Alternative;
use App\Entity\Matrix;
use App\Entity\MatrixAlternative;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class MatrixAlternativeFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        foreach ($this->getData() as $data) {
            $ma = new MatrixAlternative();

            /** @var Matrix $matrix */
            $matrix = $this->getReference($data['matrix']);
            /** @var Alternative $alternative */
            $alternative = $this->getReference($data['alternative']);

            $ma->setMatrix($matrix);
            $ma->setAlternative($alternative);

            $manager->persist($ma);
        }

        $manager->flush();
    }

    private function getData(): array
    {
        return [
            [
                'matrix' => MatrixFixtures::REF_MATRIX_BPLA,
                'alternative' => AlternativeFixtures::REF_ALT_MART_MK_II,
            ],
            [
                'matrix' => MatrixFixtures::REF_MATRIX_BPLA,
                'alternative' => AlternativeFixtures::REF_ALT_CHACAL_2,
            ],
            [
                'matrix' => MatrixFixtures::REF_MATRIX_BPLA,
                'alternative' => AlternativeFixtures::REF_ALT_MARULA,
            ],
            [
                'matrix' => MatrixFixtures::REF_MATRIX_BPLA,
                'alternative' => AlternativeFixtures::REF_ALT_MIRACH_26,
            ],
            [
                'matrix' => MatrixFixtures::REF_MATRIX_BPLA,
                'alternative' => AlternativeFixtures::REF_ALT_CRECERELLE,
            ],
            [
                'matrix' => MatrixFixtures::REF_MATRIX_BPLA,
                'alternative' => AlternativeFixtures::REF_ALT_LUNA_X_2000,
            ],
        ];
    }

    public function getDependencies(): array
    {
        return [
            AlternativeFixtures::class,
            MatrixFixtures::class,
        ];
    }
}
