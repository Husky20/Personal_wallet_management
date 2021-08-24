<?php

namespace App\Tests\Forms;

use App\Entity\Payment;
use App\Form\PaymentType;

use Symfony\Component\Form\Test\TypeTestCase;

class PaymentTypeTest extends TypeTestCase
{
    public function testSubmitValidData()
    {

        $formatData = [
            'name' => 'TestPayment'
        ];

        $model = new Payment();
        $form = $this->factory->create(PaymentType::class, $model);

        $expected = new Payment();
        $expected->setName('TestPayment');

        $form->submit($formatData);
        $this->assertTrue($form->isSynchronized());

        $this->assertEquals($expected, $model);
    }
}
