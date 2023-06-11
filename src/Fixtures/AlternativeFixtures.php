<?php

namespace App\Fixtures;

use App\Entity\Alternative;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AlternativeFixtures extends Fixture
{
    public const REF_ALT_MART_MK_II = 'ref_alt_mart_mk_ii';
    public const REF_ALT_CHACAL_2 = 'ref_alt_chacal_2';
    public const REF_ALT_MARULA = 'ref_alt_marula';
    public const REF_ALT_MIRACH_26 = 'ref_alt_mirach_26';
    public const REF_ALT_CRECERELLE = 'ref_alt_crecerelle';
    public const REF_ALT_LUNA_X_2000 = 'ref_alt_luna_x_2000';

    public function load(ObjectManager $manager)
    {
        foreach ($this->getData() as $data) {
            $alternative = new Alternative();

            $alternative->setName($data['name']);

            $this->addReference($data['reference'], $alternative);

            $manager->persist($alternative);
        }

        $manager->flush();
    }

    private function getData(): array
    {
        return [
            [
                'reference' => self::REF_ALT_MART_MK_II,
                'name' => 'MART Mk II',
            ],
            [
                'reference' => self::REF_ALT_CHACAL_2,
                'name' => 'CHACAL-2',
            ],
            [
                'reference' => self::REF_ALT_MARULA,
                'name' => 'MARULA',
            ],
            [
                'reference' => self::REF_ALT_MIRACH_26,
                'name' => 'MIRACH-26',
            ],
            [
                'reference' => self::REF_ALT_CRECERELLE,
                'name' => 'CRECERELLE',
            ],
            [
                'reference' => self::REF_ALT_LUNA_X_2000,
                'name' => 'LUNA X-2000',
            ],
        ];
    }
}
