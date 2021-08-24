<?php

namespace App\Tests\Forms;

use App\Entity\Operation;
use App\Form\OperationType;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Form\Test\TypeTestCase;

class OperationTypeTest extends TypeTestCase
{
    public function testSubmitValidData()
    {

        $formatData = [
            'name' => 'TestOperation'
        ];

        $model = new Operation();
        $form = $this->factory->create(OperationType::class, $model);

        $expected = new Operation();
        $expected->setName('TestOperation');

        $form->submit($formatData);
        $this->assertTrue($form->isSynchronized());

        $this->assertEquals($expected, $model);
    }
}
