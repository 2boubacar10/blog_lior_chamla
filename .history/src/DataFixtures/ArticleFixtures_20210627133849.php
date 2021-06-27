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

        $faker = \Faker\Factory::create("fr_FR");

        //création de fausses categories
        for($i=1; $i<=10; $i++){
            $category = new Category();
            $category->setTitle($faker->sentence())
                     ->setDescription($faker->paragraph());

            $manager->persist($category);

            for($j=1; $j<=mt_rand(4,6); $j++){
                $article = new Article;
                $start_date = $faker->dateTimeBetween('+0 days', '+1 month');
                $start_date_clone = clone $start_date;

                $end_date = $faker->dateTimeBetween($start_date, $start_date_clone->modify('+5 hours'));

                $article->setTitle($faker->sentence());
                $article->setContent($faker->paragraph());
                $article->setImage($faker->imageUrl());
                $article->setCreatedAt(new \DateTimeImmutable);
                $article->setCategory($category);

                $manager->persist($article);

                for($k=1; $k <= mt_rand(4,10); $k++){
                    $comment = new Comment();
                    $now = new \DateTime();
                    $comment->setAuthor($faker->name())
                            ->setContent($faker->paragraph())
                            ->setCreatedAt(new \DateTime)
                            ->setAarticle($article)
                    ;

                    $manager->persist($comment);
                }
            }
        }

        

        $manager->flush();
    }
}
