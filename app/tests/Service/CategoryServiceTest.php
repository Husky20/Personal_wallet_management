<?php
/**
 * CategoryService tests.
 */

namespace App\Tests\Service;

use App\Entity\Category;
use App\Repository\CategoryRepository;
use App\Repository\TransactionRepository;
use App\Service\CategoryService;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * Class CategoryServiceTest.
 */
class CategoryServiceTest extends KernelTestCase
{
    /**
     * Category service.
     *
     * @var CategoryService|object|null
     */
    private ?CategoryService $categoryService;

    /**
     * Category repository.
     *
     * @var CategoryRepository|object|null
     */
    private ?CategoryRepository $categoryRepository;

    /**
     * Transaction repository.
     *
     * @var TransactionRepository|object|null
     */
    private ?TransactionRepository $transactionRepository;

    /**
     * Set up test.
     */
    protected function setUp(): void
    {
        self::bootKernel();
        $container = self::$container;
        $this->categoryRepository = $container->get(CategoryRepository::class);
        $this->categoryService = $container->get(CategoryService::class);
        $this->transactionRepository = $container->get(TransactionRepository::class);
    }

    /**
     * Test save.
     * @covers \App\Service\CategoryService::save
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function testSave(): void
    {
        // given
        $expectedCategory = new Category();
        $expectedCategory->setName('Test Category');

        // when
        $this->categoryService->save($expectedCategory);
        $resultCategory = $this->categoryRepository->findOneById(
            $expectedCategory->getId()
        );

        // then
        $this->assertEquals($expectedCategory, $resultCategory);
    }

    /**
     * Test delete.
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function testDelete(): void
    {
        // given
        $expectedCategory = new Category();
        $expectedCategory->setName('Test Category');
        $this->categoryRepository->save($expectedCategory);
        $expectedId = $expectedCategory->getId();

        // when
        $this->categoryService->delete($expectedCategory);
        $result = $this->categoryRepository->findOneById($expectedId);

        // then
        $this->assertNull($result);
    }

    /**
     * Test pagination empty list.
     */
    public function testCreatePaginatedListEmptyList(): void
    {
        // given
        $page = 0;
        $dataSetSize = 3;
        $expectedResultSize = 0;

        $counter = 0;
        while ($counter < $dataSetSize) {
            $category = new Category();
            $category->setName('Test Category #'.$counter);
            $this->categoryRepository->save($category);

            ++$counter;
        }

        // when
        $result = $this->categoryService->createPaginatedList($page);

        // then
        $this->assertEquals($expectedResultSize, $result->count());
    }

    // other tests for paginated list
    /**
     * Test pagination list.
     *
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function testCreatePaginatedList(): void
    {
        // given
        $page = 1;
        $dataSetSize = 3;
        $expectedResultSize = 10;

        $counter = 0;
        while ($counter < $dataSetSize) {
            $category = new Category();
            $category->setName('Test Category #'.$counter);
            $this->categoryRepository->save($category);

            ++$counter;
        }

        // when
        $result = $this->categoryService->createPaginatedList($page);

        // then
        $this->assertEquals($expectedResultSize, $result->count());
    }
}