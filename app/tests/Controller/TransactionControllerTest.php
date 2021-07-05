<?php
/**
 * Category Controller test.
 */

namespace App\Tests\Controller;

use App\Entity\Category;
use App\Entity\Operation;
use App\Entity\Payment;
use App\Entity\Tag;
use App\Entity\Transaction;
use App\Entity\User;
use App\Entity\Wallet;
use App\Repository\CategoryRepository;
use App\Repository\OperationRepository;
use App\Repository\PaymentRepository;
use App\Repository\TagRepository;
use App\Repository\TransactionRepository;
use App\Repository\UserRepository;
use App\Repository\WalletRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\BrowserKit\Cookie;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

/**
 * Class CategoryControllerTest.
 */
class TransactionControllerTest extends WebTestCase
{
    /**
     * Test client.
     */
    private KernelBrowser $httpClient;

    /**
     * Set up tests.
     */
    public function setUp(): void
    {
        $this->httpClient = static::createClient();
    }

    /**
     * Test index route for anonymous user.
     */
    public function testIndexRouteAnonymousUser(): void
    {
        // given
        $expectedStatusCode = 200;

        // when
        $this->httpClient->request('GET', '/transaction/');
        $resultStatusCode = $this->httpClient->getResponse()->getStatusCode();

        // then
        $this->assertEquals($expectedStatusCode, $resultStatusCode);
    }

    /**
     * Test index route for anonymous user.
     */
    public function testIndexRouteAdminUser(): void
    {
        // given
        $expectedStatusCode = 200;
        $admin = $this->createUser(['ROLE_ADMIN', 'ROLE_USER']);
        $this->logIn($admin);
        // when
        $this->httpClient->request('GET', '/transaction/');
        $resultStatusCode = $this->httpClient->getResponse()->getStatusCode();

        // then
        $this->assertEquals($expectedStatusCode, $resultStatusCode);
    }

    public function testShowTransaction(): void
    {
        // given
        $expectedStatusCode = 200;
        $expectedTransaction = $this->createTransaction();
        $id = $expectedTransaction->getId();
        // when
        $this->httpClient->request('GET', '/transaction/'.$id);
        $result = $this->httpClient->getResponse()->getStatusCode();

        // then
        $this->assertEquals($expectedStatusCode, $result);
    }

    /**
     * Create category.
     */
    private function createCategory()
    {
        $category = new Category();
        $category->setName('TName');
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
     * Test index route for anonymous user.
     */
    public function testIndexRouteSearch(): void
    {
        // given
        $expectedStatusCode = 200;

        // when
        $aa = $this->httpClient->request('GET', '/transaction/');
        $resultStatusCode = $this->httpClient->getResponse()->getStatusCode();
        $form = $aa->filter('form')->form();
        $form['search']->setValue('query');
        $this->httpClient->submit($form);

        // then
        $this->assertEquals($expectedStatusCode, $resultStatusCode);
    }

    /**
     * Simulate user log in.
     *
     * @param User $user User entity
     */
    private function logIn(User $user): void
    {
        $session = self::$container->get('session');

        $firewallName = 'main';
        $firewallContext = 'main';

        $token = new UsernamePasswordToken($user, null, $firewallName, $user->getRoles());
        $session->set('_security_'.$firewallContext, serialize($token));
        $session->save();

        $cookie = new Cookie($session->getName(), $session->getId());
        $this->httpClient->getCookieJar()->set($cookie);
    }

    /**
     * Create transaction.
     */
    private function createTransaction(): Transaction
    {
        $transaction = new Transaction();
        $transaction->setName('TName');
        $transaction->setDate(\DateTime::createFromFormat('Y-m-d', "2021-05-09"));
        $transaction->setAmount('11');
        $transaction->setCategory($this->createCategory());
        $transaction->setWallet($this->createWallet());
        $transaction->setOperation($this->createOperation());
        $transaction->setPayment($this->createPayment());
        $transaction->addTag($this->createTag());

        $transactionRepository = self::$container->get(TransactionRepository::class);
        $transactionRepository->save($transaction);

        return $transaction;
    }

    /**
     * Test create transaction for admin user.
     */
    public function testCreateTransactionAdminUser(): void
    {
        // given
        $expectedStatusCode = 301;
        $admin = $this->createUser(['ROLE_ADMIN', 'ROLE_USER']);
        $this->logIn($admin);
        // when
        $this->httpClient->request('GET', '/transaction/new/');
        $resultStatusCode = $this->httpClient->getResponse()->getStatusCode();

        // then
        $this->assertEquals($expectedStatusCode, $resultStatusCode);
    }

    /**
     * Test create transaction for admin user.
     */
    public function testCreateTransactionNonAdmin(): void
    {
        // given
        $expectedStatusCode = 301;
        $admin = $this->createUser([User::ROLE_USER]);
        $this->logIn($admin);
        // when
        $this->httpClient->request('GET', '/Transactions/new/');
        $resultStatusCode = $this->httpClient->getResponse()->getStatusCode();

        // then
        $this->assertEquals($expectedStatusCode, $resultStatusCode);
    }

    /**
     * Create user.
     *
     * @param array $roles User roles
     *
     * @return User User entity
     */
    private function createUser(array $roles): User
    {
        $passwordEncoder = self::$container->get('security.password_encoder');
        $user = new User();
        $user->setEmail('user1@example.com');
        $user->setRoles($roles);
        $user->setPassword(
            $passwordEncoder->encodePassword(
                $user,
                'p@w0rd'
            )
        );
        $userRepository = self::$container->get(UserRepository::class);
        $userRepository->save($user);

        return $user;
    }


}
