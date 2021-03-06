<?php
/**
 * Wallet fixtures.
 */

namespace App\DataFixtures;

use App\Entity\Wallet;
use Doctrine\Persistence\ObjectManager;

/**
 * Class WalletFixtures.
 */
class WalletFixtures extends AbstractBaseFixtures
{
    /**
     * Load data.
     *
     * @param \Doctrine\Persistence\ObjectManager $manager Persistence object manager
     */
    public function loadData(ObjectManager $manager): void
    {
        $this->createMany(20, 'wallets', function ($i) {
            $wallet = new Wallet();
            $wallet->setName($this->faker->word);
            $wallet->setBalance($this->faker->numberBetween(1, 700000));
            $wallet->setCreatedAt($this->faker->dateTimeBetween('-100 days', '-1 days'));
            $wallet->setUpdatedAt($this->faker->dateTimeBetween('-100 days', '-1 days'));

            return $wallet;
        });

        $manager->flush();
    }
}
