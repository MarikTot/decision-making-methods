<?php

namespace App\Fixtures;

use App\Entity\Matrix;
use App\Entity\User;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class MatrixFixtures extends Fixture implements DependentFixtureInterface
{
    public const REF_MATRIX_BPLA = 'ref_matrix_bpla';

    public function load(ObjectManager $manager)
    {
        foreach ($this->getData() as $data) {
            $matrix = new Matrix();

            $matrix->setTitle($data['title']);

            $matrix->setCreatedAt(new DateTimeImmutable());

            /** @var User $user */
            $user = $this->getReference($data['createdBy']);

            $matrix->setCreatedBy($user);

            $this->addReference($data['reference'], $matrix);

            $manager->persist($matrix);
        }

        $manager->flush();
    }

    private function getData(): array
    {
        return [
            [
                'reference' => self::REF_MATRIX_BPLA,
                'title' => 'БПЛА',
                'createdBy' => UserFixtures::REF_USER_ADMIN,
            ],
        ];
    }

    public function getDependencies()
    {
        return [
            UserFixtures::class,
        ];
    }
}
