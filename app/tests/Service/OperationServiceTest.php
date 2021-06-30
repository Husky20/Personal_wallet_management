<?php
/**
 * operationService tests.
 */

namespace App\Tests\Service;

use App\Entity\Operation;
use App\Repository\OperationRepository;
use App\Repository\TransactionRepository;
use App\Service\OperationService;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * Class OperationServiceTest.
 */
class OperationServiceTest extends KernelTestCase
{
    /**
     * Operation service.
     *
     * @var OperationService|object|null
     */
    private ?OperationService $operationService;

    /**
     * Operation repository.
     *
     * @var OperationRepository|object|null
     */
    private ?OperationRepository $operationRepository;

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
        $this->operationRepository = $container->get(OperationRepository::class);
        $this->operationService = $container->get(OperationService::class);
        $this->transactionRepository = $container->get(TransactionRepository::class);
    }

    /**
     * Test save.
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function testSave(): void
    {
        // given
        $expectedOperation = new Operation();
        $expectedOperation->setName('Test Operation');

        // when
        $this->operationService->save($expectedOperation);
        $resultOperation = $this->operationRepository->findOneById(
            $expectedOperation->getId()
        );

        // then
        $this->assertEquals($expectedOperation, $resultOperation);
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
        $expectedOperation = new Operation();
        $expectedOperation->setName('Test Operation');
        $this->operationRepository->save($expectedOperation);
        $expectedId = $expectedOperation->getId();

        // when
        $this->operationService->delete($expectedOperation);
        $result = $this->operationRepository->findOneById($expectedId);

        // then
        $this->assertNull($result);
    }

    /**
     * Test find by id.
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function testFindById(): void
    {
        // given
        $expectedOperation = new Operation();
        $expectedOperation->setName('Test Operation');
        $this->operationRepository->save($expectedOperation);

        // when
        $result = $this->operationService->findOneById($expectedOperation->getId());

        // then
        $this->assertEquals($expectedOperation->getId(), $result->getId());
    }

    /**
     * Test pagination empty list.
     */
    public function testCreatePaginatedListEmptyList(): void
    {
        // given
        $page = 1;
        $dataSetSize = 3;
        $expectedResultSize = 0;

        $counter = 0;
        while ($counter < $dataSetSize) {
            $operation = new Operation();
            $operation->setName('Test Operation #'.$counter);
            $this->operationRepository->save($operation);

            ++$counter;
        }

        // when
        $result = $this->operationService->createPaginatedList($page);

        // then
        $this->assertEquals($expectedResultSize, $result->count());
    }

    // other tests for paginated list
}