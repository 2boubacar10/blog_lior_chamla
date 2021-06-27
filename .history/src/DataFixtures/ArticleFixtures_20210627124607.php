<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\Category;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class ArticleFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);

        $faker = Faker\Factory::create("fr_FR");

        //création de fausses categories
        for($i=1; $i<=10; $i++){
            $category = new Category();
            $category->setTitle($faker->sentence())
                     ->setDescription($faker->paragraph());

            $manager->persist($category);

            for($j=1; $j<=10; $j++){
                $article = new Article;
                $article->setTitle("Titre de mon article n°$j");
                $article->setContent("Contenu de mon article n°$j");
                $article->setImage("http://placehold.it/350x150");
                $article->setCreatedAt(new \DateTimeImmutable());

                $manager->persist($article);
            }
        }

        

        $manager->flush();
    }
}
