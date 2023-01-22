<?php

namespace App\DataFixtures;

use App\Entity\Post;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Faker;

class PostsFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create('fr_FR');

        for($posts = 1; $posts <= 100; $posts++){
            $user = $this->getReference('user_'. $faker->numberBetween(1, 50));

            $post = new Post();

            $post->setUser($user);
            $post->setName($faker->realText(100));
            $post->setSlug('lorem-ipsum-dolor-sit-amet-consectetur-' . 'slug-offre-' . $posts);
            $post->setContent($faker->realText(400));
            $post->setOnline($faker->numberBetween(0, 1));

            $manager->persist($post);
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
