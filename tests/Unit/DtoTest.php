<?php

namespace App\Tests\Unit;

use App\Dto\AlternativeDto;
use App\Dto\CharacteristicDto;
use App\Dto\TypeDto;
use App\Entity\Alternative;
use App\Entity\Characteristic;
use App\Entity\Type;
use App\Entity\TypeEnum;
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
        $type = new Type();

        $type->setId(1);
        $type->setName('Test type 1');
        $type->setDefaultType(false);

        $enum1 = new TypeEnum();

        $enum1->setId(1);
        $enum1->setType($type);
        $enum1->setValue('Test1');

        $type->addTypeEnum($enum1);

        $enum2 = new TypeEnum();

        $enum2->setId(1);
        $enum2->setType($type);
        $enum2->setValue('Test2');

        $type->addTypeEnum($enum2);

        $characteristic = new Characteristic();

        $characteristic->setId(1);
        $characteristic->setName('Test');
        $characteristic->setMultiple(false);
        $characteristic->setType($type);

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
