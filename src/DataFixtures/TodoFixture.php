<?php

namespace App\DataFixtures;

use App\Entity\Todo;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

ini_set('memory_limit', '-1');

class TodoFixture extends Fixture
{
    private const STATUSES = [
        'new',
        'rejected',
        'in_progress',
        'completed',
    ];

    /**
     * @inheritDoc
     */
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();
        for ($i = 0; $i < 200; $i++) {
            for ($j = 0; $j < 50000; $j++) {
                $todo = new Todo();
                $todo->setTitle($faker->text(30));
                $todo->setLikesCount($faker->numberBetween(0, 10000000));
                $todo->setStatus($faker->randomElement(self::STATUSES));
                $todo->setCreatedAt($faker->dateTimeBetween('-100 days', '-1 days'));
                $manager->persist($todo);
            }

            $manager->flush();
        }

    }
}