<?php

namespace App\DataFixtures;

use App\Entity\Event;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Faker;

class EventsFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create('fr_FR');

        for($events = 1; $events <= 100; $events++){
            $user = $this->getReference('user_'. $faker->numberBetween(1, 50));

            $event = new Event();

            $event->setUser($user);
            $event->setName($faker->realText(100));
            $event->setSlug('lorem-ipsum-dolor-sit-amet-consectetur-' . 'slug-offre-' . $events);
            $event->setDescription($faker->realText(400));
            $event->setOnline($faker->numberBetween(0, 1));
            $event->setStartAt(new \DateTimeImmutable());
            $event->setEndAt(new \DateTimeImmutable());
            $event->setHeureDebut(new \DateTimeImmutable());
            $event->setHeureFin(new \DateTimeImmutable());

            $manager->persist($event);
        }
        

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            UsersFixtures::class,
        ];
    }
}
