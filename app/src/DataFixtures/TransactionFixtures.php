<?php
/**
 * Transaction fixtures.
 */
namespace App\DataFixtures;

use App\Entity\Transaction;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

/**
 * Class TransactionFixtures.
 */
class TransactionFixtures extends AbstractBaseFixtures implements DependentFixtureInterface
{
    /**
     * Load data.
     *
     * @param \Doctrine\Persistence\ObjectManager $manager Persistence object manager
     */
    public function loadData(ObjectManager $manager): void
    {
        $this->createMany(50, 'transactions', function ($i) {
            $transaction = new Transaction();
            $transaction->setName($this->faker->sentence);
            $transaction->setDate($this->faker->dateTimeThisYear);
            $transaction->setAmount($this->faker->randomNumber());
            $transaction->setCreatedAt($this->faker->dateTimeBetween('-100 days', '-1 days'));
            $transaction->setUpdatedAt($this->faker->dateTimeBetween('-100 days', '-1 days'));
            $transaction->setIdCategory($this->getRandomReference('categories'));
            $transaction->setIdOperation($this->getRandomReference('operations'));
            $transaction->setIdPayment($this->getRandomReference('payments'));
            $transaction->setIdWallet($this->getRandomReference('wallets'));

            return $transaction;
        });

        $manager->flush();
    }

    /**
     * This method must return an array of fixtures classes
     * on which the implementing class depends on.
     *
     * @return array Array of dependencies
     */
    public function getDependencies(): array
    {
        return [CategoryFixtures::class,OperationFixtures::class,PaymentFixtures::class,WalletFixtures::class];
    }
}
