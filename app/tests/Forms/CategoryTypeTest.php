<?php

namespace App\Tests\Forms;

use App\Entity\Category;
use App\Form\CategoryType;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Form\Test\TypeTestCase;

class CategoryTypeTest extends TypeTestCase
{

    public function testSubmitValidDate()
    {

        $formatData = [
          'name' => 'TestCategory'
        ];

        $model = new Category();
        $form = $this->factory->create(CategoryType::class, $model);

        $expected = new Category();
        $expected->setName('TestCategory');

        $form->submit($formatData);
        $this->assertTrue($form->isSynchronized());

        $this->assertEquals($expected, $model);
    }

}
