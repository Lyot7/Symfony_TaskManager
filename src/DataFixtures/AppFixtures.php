<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Tag;
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

        // Création de nos 5 catégories
        for ($c=0; $c < 5; $c++) { 
            
            // Création d'un nouvel objet Tag
            $tag = new Tag;

            // On ajout un nom à notre catégorie
            $tag->setName($faker->colorName());

            // On fait persister les données
            $manager->persist($tag);
        }

        $manager->flush();

        // Récupération des catégories crées
        $allTags = $manager->getRepository(Tag::class)->findAll();

        // Création entre 15 et 30 tâches aléatoirement
        for ($t = 0; $t < mt_rand(150, 300); $t++) {

            // Création d'un nouvel objet Task
            $task = new Task;

            // On nourrit l'objet Task
            $task->setName($faker->sentence(6))
                ->setDescription($faker->paragraph(3))
                ->setCreatedAt(new \DateTime()) // Attention les dates sont créées en fonction du réglage serveur
                ->setDueAt($faker->dateTimeBetween('now', '6 months')) // Même chose ici
                ->setTag($faker->randomElement($allTags));

            // On fait persister les données
            $manager->persist($task);

        }

        $manager->flush();
    }
}
