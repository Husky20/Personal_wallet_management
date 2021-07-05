<?php
/**
 * WalletService tests.
 */

namespace App\Tests\Service;

use App\Entity\Wallet;
use App\Repository\WalletRepository;
use App\Repository\TransactionRepository;
use App\Service\WalletService;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * Class WalletServiceTest.
 */
class WalletServiceTest extends KernelTestCase
{
    /**
     * Wallet service.
     *
     * @var WalletService|object|null
     */
    private ?WalletService $walletService;

    /**
     * Wallet repository.
     *
     * @var WalletRepository|object|null
     */
    private ?WalletRepository $walletRepository;

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
        $this->walletRepository = $container->get(WalletRepository::class);
        $this->walletService = $container->get(WalletService::class);
        $this->transactionRepository = $container->get(TransactionRepository::class);
    }

    /**
     * Test save.
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function testSave(): void
    {
        // given
        $expectedWallet = new Wallet();
        $expectedWallet->setName('Test Wallet');
        $expectedWallet->setBalance('100');

        // when
        $this->walletService->save($expectedWallet);
        $resultWallet = $this->walletRepository->findOneById(
            $expectedWallet->getId()
        );

        // then
        $this->assertEquals($expectedWallet, $resultWallet);
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
        $expectedWallet = new Wallet();
        $expectedWallet->setName('Test Wallet');
        $expectedWallet->setBalance('100');
        $this->walletRepository->save($expectedWallet);
        $expectedId = $expectedWallet->getId();

        // when
        $this->walletService->delete($expectedWallet);
        $result = $this->walletRepository->findOneById($expectedId);

        // then
        $this->assertNull($result);
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
            $wallet = new Wallet();
            $wallet->setName('Test Wallet #'.$counter);
            $wallet->setBalance('100');
            $this->walletRepository->save($wallet);

            ++$counter;
        }

        // when
        $result = $this->walletService->createPaginatedList($page);

        // then
        $this->assertEquals($expectedResultSize, $result->count());
    }

    // other tests for paginated list
}
