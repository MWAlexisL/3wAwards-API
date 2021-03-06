<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Agency;
use AppBundle\Entity\Client;
use AppBundle\Entity\Image;
use AppBundle\Entity\Member;
use AppBundle\Entity\Project;
use AppBundle\Entity\SiteType;
use AppBundle\Entity\Target;
use AppBundle\Manager\ProjectManager;
use Doctrine\Common\DataFixtures\BadMethodCallException;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

class ProjectFixtures extends Fixture implements OrderedFixtureInterface
{
    private $projects = [
        ['Open Annuaire', '3wAwards', 'That one cool website', 'Project test', 'DataStudio'],
        [
            'Audietis nos dixistis loco iuratis.',
            'Iam exitialis cibos inediae flumen.',
            'Propositum aliis quoque eius neminem.',
            'Enim vivendi Eusebius tribunos Eusebius.',
            'Illorum video fines ut De.',
        ],
        [
            'Sicut Quid Quid cum Quid.',
            'Reque omittam verae inventu istum',
            'Proruperunt hac feris tamen in.',
            'Modum Gallus milites ultra mortalem.',
            'Amplis post quam ut inlustris',

        ],
        /* websiteUrl */
        [
            'https://angular.io/',
            'http://www.nodevo.com/',
            'http://www.cabestan.com/',
            'https://symfony.com/',
            'https://arroi.fr/fr/dusensaloeuvre/',
        ],
    ];

    private $status = [Project::STATUS_PENDING, Project::STATUS_ACCEPTED, Project::STATUS_REFUSED];

    /**
     * @var ProjectManager
     */
    private $projectManager;

    public function __construct(ProjectManager $projectManager)
    {
        $this->projectManager = $projectManager;
    }

    /**
     * @return int*
     */
    public function getOrder()
    {
        return 4;
    }

    /**
     * @param ObjectManager $manager
     *
     * @throws BadMethodCallException
     */
    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < 5; $i++) {
            $this->createProject($manager, $i);
        }
        $manager->flush();
    }

    /**
     * @param ObjectManager $manager
     *
     * @param               $i
     *
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    private function createProject(ObjectManager $manager, $i)
    {
        $project = new Project();
        /** @var Member $member */
        $member = $this->getReference('member_'.rand(1,2));

        /** @var Image $image */
        $image = $this->getReference('image_'.rand(1, 5));

        $project
            ->setProjectName($this->projects[0][$i])
            ->setProjectDescription($this->projects[1][$i])
            ->setPublicationDate(new \DateTime(rand(1, 28).'-'.rand(1, 12).'-'.rand(2012, 2018)))
            ->addImage($image)
            ->addMember($member)
            ->setNoticableDescription($this->projects[2][$i])
            ->setProjectUrl($this->projects[3][$i])
            ->setStatus($this->status[rand(0, 2)]);

        /** @var Target $target */
        $target = $this->getReference('target_'.rand(0,1));
        $project->setTarget($target);

        /** @var SiteType $siteType */
        $siteType = $this->getReference('site_type'.rand(0,6));
        $project->setSiteType($siteType);



        if (rand(1, 2) == 1) {
            /** @var Agency $agency */
            $agency = $this->getReference('agency_'.rand(0, 4));
            $project->setAgency($agency);
        } else {
            /** @var Client $client */
            $client = $this->getReference('client_'.rand(0, 4));
            $project->setClient($client);
        }

        $manager->persist($project);
        $this->addReference('project_'.$i, $project);
    }
}
