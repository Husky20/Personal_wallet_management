<?php
/**
 * Category controller tests.
 */
namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * class CategoryControllerTest.
 */
class CategoryControllerTest extends WebTestCase{
    /**
     * Test /category route.
     */
    public function testCategoryRoute(): void{
        $client = static::createClient();

        $client->request('GET', '/category');
        $resultHttpStatusCode = $client->getResponse()->getStatusCode();

        $this->assertEquals(404, $resultHttpStatusCode);
    }
}
