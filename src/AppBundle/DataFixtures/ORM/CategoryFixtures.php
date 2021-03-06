<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Category;
use Doctrine\Common\DataFixtures\BadMethodCallException;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

class CategoryFixtures extends Fixture implements OrderedFixtureInterface
{
    private $categories = [
        Category::CATEGORY_ORIGINALITY,
        Category::CATEGORY_READABILITY,
        Category::CATEGORY_NAVIGATION,
        Category::CATEGORY_INTERACTIVITY,
        Category::CATEGORY_CONTENT_QUALITY,
        Category::CATEGORY_FUNCTIONALITY,
        Category::CATEGORY_REACTIVITY,
    ];

    /**
     * @return int
     */
    public function getOrder()
    {
        return 1;
    }

    /**
     * @param ObjectManager $manager
     *
     * @throws BadMethodCallException
     */
    public function load(ObjectManager $manager)
    {
        foreach ($this->categories as $key => $value) {
            $this->createCategory($manager, $key);
        }
        $manager->flush();
    }

    /**
     * @param ObjectManager $manager
     * @param int           $i
     *
     * @throws BadMethodCallException
     */
    private function createCategory(ObjectManager $manager, $i)
    {
        $category = new Category();
        $category->setLibelle($this->categories[$i]);

        $manager->persist($category);
        $this->addReference('category_'.$i, $category);
    }
}
