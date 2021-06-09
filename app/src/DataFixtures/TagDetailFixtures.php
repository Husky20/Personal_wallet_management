<?php
/**
 * TagDetail fixtures.
 */

namespace App\DataFixtures;

use App\Entity\TagDetail;
use Doctrine\Persistence\ObjectManager;

/**
 * Class TagDetailFixtures.
 */
class TagDetailFixtures extends AbstractBaseFixtures
{
    /**
     * Load data.
     *
     * @param \Doctrine\Persistence\ObjectManager $manager Persistence object manager
     */
    public function loadData(ObjectManager $manager): void
    {
        $this->createMany(20, 'tagDetails', function ($i) {
            $tagDetail = new TagDetail();
            return $tagDetail;
        });

        $manager->flush();
    }
}