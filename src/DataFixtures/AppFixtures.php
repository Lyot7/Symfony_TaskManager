<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Task;
use DateTimeImmutable;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);

        $faker = Factory::create('fr_FR');

        // Création entre 15 et 30 tâches aléatoirement
        for ($t = 0; $t < mt_rand(15, 30); $t++) {

            // Création d'un nouvel objet Task
            $task = new Task;

            // On nourrit l'objet Task
            $task->setName($faker->sentence(6))
                ->setDescription($faker->paragraph(3))
                ->setCreatedAt(new \DateTimeImmutable()) // Attention les dates sont créées en fonction du réglage serveur
                ->setDueAt(DateTimeImmutable::createFromMutable($faker->dateTimeBetween('now', '6 months'))); // Même chose ici

            // On fait persister les données
            $manager->persist($task);

        }

        $manager->flush();
    }
}
