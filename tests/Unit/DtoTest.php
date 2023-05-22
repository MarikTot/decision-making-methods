<?php

namespace App\Tests\Unit;

use App\Dto\AlternativeDto;
use App\Dto\CharacteristicDto;
use App\Dto\CharacteristicTypeDto;
use App\Entity\Alternative;
use App\Entity\Characteristic;
use App\Entity\CharacteristicType;
use App\Entity\CharacteristicTypeEnum;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;

class DtoTest extends TestCase
{
    public function testCreateAlternativeDto()
    {
        $alternative = new Alternative();

        $alternative->setId(1);
        $alternative->setName('Test');
        $alternative->setCreatedAt(new DateTimeImmutable());

        $alternativeDto = new AlternativeDto($alternative);

        $this->assertSame([
            'id' => 1,
            'name' => 'Test',
        ], $alternativeDto->toArray());
    }

    public function testCreateCharacteristicDto()
    {
        $characteristicType = new CharacteristicType();

        $characteristicType->setId(1);
        $characteristicType->setName('Test type 1');
        $characteristicType->setDefaultType(false);

        $enum1 = new CharacteristicTypeEnum();

        $enum1->setId(1);
        $enum1->setType($characteristicType);
        $enum1->setValue('Test1');

        $characteristicType->addCharacteristicTypeEnum($enum1);

        $enum2 = new CharacteristicTypeEnum();

        $enum2->setId(1);
        $enum2->setType($characteristicType);
        $enum2->setValue('Test2');

        $characteristicType->addCharacteristicTypeEnum($enum2);

        $characteristic = new Characteristic();

        $characteristic->setId(1);
        $characteristic->setName('Test');
        $characteristic->setMultiple(false);
        $characteristic->setType($characteristicType);

        $characteristicDto = new CharacteristicDto($characteristic);

        $this->assertSame([
            'id' => 1,
            'name' => 'Test',
            'multiple' => false,
            'type' => [
                'name' => 'Test type 1',
                'enum' => [
                    'Test1',
                    'Test2',
                ],
            ],
        ], $characteristicDto->toArray());
    }
}
