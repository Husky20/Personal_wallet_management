<?php

namespace App\Tests\Forms;

use App\Form\WalletType;
use App\Entity\Wallet;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Form\Test\TypeTestCase;

class WalletTypeTest extends TypeTestCase
{
    public function testSubmitValidDate()
    {

        $formatData = [
            'name' => 'TestWallet',
            'balance' => 2000
        ];

        $model = new Wallet();
        $form = $this->factory->create(WalletType::class, $model);

        $expected = new Wallet();
        $expected->setName('TestWallet');
        $expected->setBalance(2000);

        $form->submit($formatData);
        $this->assertTrue($form->isSynchronized());

        $this->assertEquals($expected, $model);
    }
}
