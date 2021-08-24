<?php

namespace App\Tests\Forms;

use App\Entity\Tag;
use App\Form\TagType;


use PHPUnit\Framework\TestCase;
use Symfony\Component\Form\Test\TypeTestCase;

class TagTypeTest extends TypeTestCase
{
    public function testSubmitValidDate()
    {

        $formatData = [
            'name' => 'TestTag'
        ];

        $model = new Tag();
        $form = $this->factory->create(TagType::class, $model);

        $expected = new Tag();
        $expected->setName('TestTag');

        $form->submit($formatData);
        $this->assertTrue($form->isSynchronized());

        $this->assertEquals($expected, $model);
    }
}
