<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Rating;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

class RatingFixtures extends Fixture implements OrderedFixtureInterface
{
    private $ratings = [
        '',
        '',
        '',
        '',
        '',
        ''
    ];

    /**
     * @return int
     */
    public function getOrder()
    {
        return 2;
    }

    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {

    }

    /**
     * @param ObjectManager $manager
     */
    private function createRating(ObjectManager $manager)
    {
        $rating = new Rating();
    }
}