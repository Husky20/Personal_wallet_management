<?php
/**
 * TransactionService tests.
 */

namespace App\Tests\Service;

use App\Entity\Category;
use App\Entity\Operation;
use App\Entity\Wallet;
use App\Entity\Payment;
use App\Entity\User;
use App\Entity\Tag;
use App\Entity\Transaction;
use App\Repository\CategoryRepository;
use App\Repository\OperationRepository;
use App\Repository\PaymentRepository;
use App\Repository\UserRepository;
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
        $this->userRepository = $container->get(UserRepository::class);
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
        $expectedTransaction->setDate('2021-07-07');
        $expectedTransaction->setPayment($this->createPayment());
        $expectedTransaction->setCategory($this->createCategory());
        $expectedTransaction->setOperation($this->createOperation());
        $expectedTransaction->addTag($this->createTag());
        $expectedTransaction->setWallet($this->createWallet());
        $expectedTransaction->setAmount('1000');
        $expectedTransaction->setAuthor($this->createUser('user@example.com'));


        // when
        $this->transactionService->save($expectedTransaction);
        $resultTransaction = $this->transactionRepository->findOneById(
            $expectedTransaction->getId()
        );

        // then
        $this->assertEquals($expectedTransaction, $resultTransaction);
    }

    /**
     * Create Category.
     * @return Category
     */
    private function createCategory()
    {
        $category = new Category();
        $category->setName('TCategory');
        $categoryRepository = self::$container->get(CategoryRepository::class);
        $categoryRepository->save($category);

        return $category;
    }
    /**
     * Create Payment.
     * @return Payment
     */
    private function createPayment()
    {
        $payment = new Payment();
        $payment->setName('TPayment');
        $paymentRepository = self::$container->get(PaymentRepository::class);
        $paymentRepository->save($payment);

        return $payment;
    }
    /**
     * Create Operation.
     * @return Operation
     */
    private function createOperation()
    {
        $operation = new Operation();
        $operation->setName('TOperation');
        $operationRepository = self::$container->get(OperationRepository::class);
        $operationRepository->save($operation);

        return $operation;
    }
    /**
     * Create Tag.
     * @return Tag
     */
    private function createTag()
    {
        $tag = new Tag();
        $tag->setName('TTag');
        $tagRepository = self::$container->get(TagRepository::class);
        $tagRepository->save($tag);

        return $tag;
    }
    /**
     * Create Wallet.
     * @return Wallet
     */
    private function createWallet()
    {
        $wallet = new Wallet();
        $wallet->setName('TWallet');
        $wallet->setBalance('1000');
        $walletRepository = self::$container->get(WalletRepository::class);
        $walletRepository->save($wallet);

        return $wallet;
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
        $expectedTransaction->setName('Test Transaction');
        $expectedTransaction->setDate('2021-07-07');
        $expectedTransaction->setPayment($this->createPayment());
        $expectedTransaction->setCategory($this->createCategory());
        $expectedTransaction->setOperation($this->createOperation());
        $expectedTransaction->addTag($this->createTag());
        $expectedTransaction->setWallet($this->createWallet());
        $expectedTransaction->setAmount('1000');
        $expectedTransaction->setAuthor($this->createUser('user@example.com'));
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
        $expectedTransaction->setName('Test Transaction');
        $expectedTransaction->setDate('2021-07-07');
        $expectedTransaction->setPayment($this->createPayment());
        $expectedTransaction->setCategory($this->createCategory());
        $expectedTransaction->setOperation($this->createOperation());
        $expectedTransaction->addTag($this->createTag());
        $expectedTransaction->setWallet($this->createWallet());
        $expectedTransaction->setAmount('1000');
        $expectedTransaction->setAuthor($this->createUser('user@example.com'));
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
            $transaction->setDate('2021-07-07');
            $transaction->setPayment($this->createPayment());
            $transaction->setCategory($this->createCategory());
            $transaction->setOperation($this->createOperation());
            $transaction->addTag($this->createTag());
            $transaction->setWallet($this->createWallet());
            $transaction->setAmount('1000');
            $transaction->setAuthor($this->createUser('user@example.com'));
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