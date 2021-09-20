<?php
/**
 * Category Controller test.
 */

namespace App\Tests\Controller;

use App\Entity\Category;
use App\Entity\User;
use App\Repository\CategoryRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\BrowserKit\Cookie;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

/**
 * Class CategoryControllerTest.
 */
class CategoryControllerTest extends WebTestCase
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
        $expectedStatusCode = 302;

        // when
        $this->httpClient->request('GET', '/category');
        $resultStatusCode = $this->httpClient->getResponse()->getStatusCode();

        // then
        $this->assertEquals($expectedStatusCode, $resultStatusCode);
    }

    /**
     * Test index route for admin user.
     */
    public function testIndexRouteAdminUser(): void
    {
        $expectedStatusCode = 200;
        $adminUser = $this->createUser([User::ROLE_USER, User::ROLE_ADMIN]);
        $this->logIn($adminUser);

        // when
        $this->httpClient->request('GET', '/category/');
        $resultStatusCode = $this->httpClient->getResponse()->getStatusCode();

        // then
        $this->assertEquals($expectedStatusCode, $resultStatusCode);
    }
    /**
     * Test create film for admin user.
     */
    public function testCreateCategoryAdminUser(): void
    {
        // given
        $expectedStatusCode = 301;
        $admin = $this->createUser(['ROLE_ADMIN', 'ROLE_USER']);
        $this->logIn($admin);
        // when
        $this->httpClient->request('GET', '/category/create/');
        $resultStatusCode = $this->httpClient->getResponse()->getStatusCode();

        // then
        $this->assertEquals($expectedStatusCode, $resultStatusCode);
    }

    /**
     * Test create film for common user.
     */
    public function testCreateCategoryCommonUser(): void
    {
        // given
        $expectedStatusCode = 301;
        $user= $this->createUser(['ROLE_USER']);
        $this->logIn($user);
        // when
        $this->httpClient->request('GET', '/category/create/');
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
                'p@55w0rd'
            )
        );
        $userRepository = self::$container->get(UserRepository::class);
        $userRepository->save($user);

        return $user;
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
     * Test index route for non authorized user FOR NEW CATEGORY.
     */
    public function testIndexRouteNonAuthorizedUser(): void
    {
        // given
        $expectedStatusCode = 301;
        $user = $this->createUser([User::ROLE_USER]);
        $this->logIn($user);

        // when
        $this->httpClient->request('GET', '/category/create/');
        $resultStatusCode = $this->httpClient->getResponse()->getStatusCode();

        // then
        $this->assertEquals($expectedStatusCode, $resultStatusCode);
    }

    // edit category
    public function testEditCategory(): void
    {
        // create category
        $category = new Category();
        $category->setName('TestCategory');
        $categoryRepository = self::$container->get(CategoryRepository::class);
        $categoryRepository->save($category);

        $expected = 'TestChanged';
        // change name
        $category->setName('TestChanged');
        $categoryRepository->save($category);

        $this->assertEquals($expected, $categoryRepository->findOneByName($expected)->getName());

    }

    public function testDeleteCategory(): void
    {
        // create category
        $category = new Category();
        $category->setName('TestCategory2');
        $categoryRepository = self::$container->get(CategoryRepository::class);
        $categoryRepository->save($category);

        $expected = new Category();

        // delete
        $categoryRepository->delete($category);

        $this->assertEquals($expected, $categoryRepository->findByName('TestCategory2'));
    }
}