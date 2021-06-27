<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\Comment;
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

            for($j=1; $j<=mt_rand(4,6); $j++){
                $article = new Article;
                $article->setTitle($faker->sentence());
                $article->setContent($faker->paragraph());
                $article->setImage($faker->imageUrl());
                $article->setCreatedAt($faker->dateTimeBetween('-6 months'));
                $article->setCategory($category);

                $manager->persist($article);

                for($k=1; $k <= mt_rand(4,10); $k++){
                    $comment = new Comment();
                    $now = new \DateTime();
                    $comment->setAuthor($faker->setName())
                            ->setContent($faker->paragraph())
                    ;
                }
            }
        }

        

        $manager->flush();
    }
}
