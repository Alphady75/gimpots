<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Faker;

class UsersFixtures extends Fixture
{
    private $encoder;

    public function __construct(UserPasswordHasherInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');

        for($nbUsers = 1; $nbUsers <= 50; $nbUsers++){
            $user = new User();
            $user->setEmail($faker->email);
            if($nbUsers === 1){
                $user->setEmail('admin@gmail.com');
                $user->setRoles(['ROLE_ADMIN']);
            }else{
                $user->setRoles(['ROLE_MODERATEUR']);
            }
            $user->setNoms($faker->lastName());
            $user->setPrenoms($faker->firstName());
            $user->setGenre('Homme');
            $user->setBiographie($faker->realText(100));
            $user->setIsVerified($faker->numberBetween(0, 1));
            $user->setPassword($this->encoder->hashPassword($user, 'azerty'));
            $manager->persist($user);

            // Enregistre l'utilisateur dans une référence
            $this->addReference('user_'. $nbUsers, $user);
        }

        $manager->flush();
    }
}
