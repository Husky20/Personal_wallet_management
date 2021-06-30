<?php
/**
 * TransactionService tests.
 */

namespace App\Tests\Service;

use App\Entity\Transaction;
use App\Repository\CategoryRepository;
use App\Repository\OperationRepository;
use App\Repository\PaymentRepository;
use App\Repository\WalletRepository;
use App\Repository\TagRepository;
use App\Repository\TransactionRepository;
use App\Service\TransactionService;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * Class TransactionServiceTest.
 */
class TransactionServiceTest extends KernelTestCase
{
    /**
     * Transaction service.
     *
     * @var TransactionService|object|null
     */
    private ?TransactionService $transactionService;

    /**
     * Transaction repository.
     *
     * @var TransactionRepository|object|null
     */
    private ?TransactionRepository $transactionRepository;

    /**
     * Category repository.
     *
     * @var CategoryRepository|object|null
     */
    private ?CategoryRepository $categoryRepository;

    /**
     * Payment repository.
     *
     * @var PaymentRepository|object|null
     */
    private ?PaymentRepository $paymentRepository;

    /**
     * Wallet repository.
     *
     * @var WalletRepository|object|null
     */
    private ?WalletRepository $walletRepository;

    /**
     * Operation repository.
     *
     * @var OperationRepository|object|null
     */
    private ?OperationRepository $operationRepository;

    /**
     * Tag repository.
     *
     * @var TagRepository|object|null
     */
    private ?TagRepository $tagRepository;

    /**
     * Set up test.
     */
    protected function setUp(): void
    {
        self::bootKernel();
        $container = self::$container;
        $this->transactionRepository = $container->get(TransactionRepository::class);
        $this->transactionService = $container->get(TransactionService::class);
        $this->categoryRepository = $container->get(CategoryRepository::class);
        $this->paymentRepository = $container->get(PaymentRepository::class);
        $this->walletRepository = $container->get(WalletRepository::class);
        $this->operationRepository = $container->get(OperationRepository::class);
        $this->tagRepository = $container->get(TagRepository::class);
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
        $expectedTransaction = new Transaction();
        $expectedTransaction->setName('Test Transaction');
        $expectedTransaction->setDate('2009-08-09');


        // when
        $this->transactionService->save($expectedTransaction);
        $resultTransaction = $this->transactionRepository->findOneById(
            $expectedTransaction->getId()
        );

        // then
        $this->assertEquals($expectedTransaction, $resultTransaction);
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
        $expectedTransaction = new Transaction();
        $expectedTransaction->setName('Test Transaction');
        $this->transactionRepository->save($expectedTransaction);
        $expectedId = $expectedTransaction->getId();

        // when
        $this->transactionService->delete($expectedTransaction);
        $result = $this->transactionRepository->findOneById($expectedId);

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
        $expectedTransaction = new Transaction();
        $expectedTransaction->setName('Test Transaction');
        $this->transactionRepository->save($expectedTransaction);

        // when
        $result = $this->transactionService->findOneById($expectedTransaction->getId());

        // then
        $this->assertEquals($expectedTransaction->getId(), $result->getId());
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
            $transaction = new Transaction();
            $transaction->setName('Test Transaction #'.$counter);
            $this->transactionRepository->save($transaction);

            ++$counter;
        }

        // when
        $result = $this->transactionService->createPaginatedList($page);

        // then
        $this->assertEquals($expectedResultSize, $result->count());
    }

    // other tests for paginated list
}