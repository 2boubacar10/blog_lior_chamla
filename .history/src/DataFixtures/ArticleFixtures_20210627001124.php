<?php

namespace App\DataFixtures;

use App\Entity\Article;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class ArticleFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);

        for($i=1; $i<=10; $i++){
            $article = new Article;
            $article->setTitle("Titre de mon article n°$i");
            $article->setContent("Contenu de mon article n°$i");
            $article->setImage("http://placehold.it/350x150");
            //$article->setCreatedAt(new \Datetime());

            $manager->persist($article);
        }

        $manager->flush();
    }
}
