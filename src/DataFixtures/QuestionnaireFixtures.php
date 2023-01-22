<?php

namespace App\DataFixtures;

use App\Entity\Questionnaire;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;

class QuestionnaireFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create('fr_FR');

        for($questionnaires = 1; $questionnaires <= 150; $questionnaires++){

            $questionnaire = new Questionnaire();

            $questionnaire->setNom($faker->lastName());
            $questionnaire->setPrenom($faker->firstName());
            $questionnaire->setSitMatrimoniale('Célibataire');
            $questionnaire->setAge($faker->numberBetween(18, 99));
            $questionnaire->setNbrEnfantsCharge($faker->numberBetween(0, 10));
            $questionnaire->setSitLogement('Locataire');
            $questionnaire->setActivite($faker->title());
            $questionnaire->setRevNetMensuels($faker->numberBetween(25000, 100000));
            $questionnaire->setSecurityCode($faker->numberBetween(100000000, 999999999));
            $questionnaire->setEmail($faker->email());
            $questionnaire->setCodePostal($faker->postcode());
            $questionnaire->setTelephone($faker->phoneNumber());

            //$questionnaire->setOnline($faker->numberBetween(0, 1));

            $manager->persist($questionnaire);
        }
        

        $manager->flush();
    }
}