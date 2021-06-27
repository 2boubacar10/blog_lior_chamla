<?php

namespace App\Controller;

use App\Entity\Article;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BlogController extends AbstractController
{
    /**
     * @Route("/blog", name="blog")
     */
    public function index(): Response
    {
        $repo = $this->getDoctrine()->getRepository(Article::class);

        $articles = $repo->findAll();

        return $this->render('blog/index.html.twig', [
            'controller_name' => 'BlogController',
            'Articles' => $articles
        ]);
    }


    /**
     * @Route("/", name="home")
     */
    public function home(){
        return $this->render('blog/home.html.twig', [
            "title" => "Bienvenue les amis!",
            "age" => 31
        ]);
    }



    /**
     * @Route("/blog/{id}", name="blog_show")
     */
    public function show($id){
        $repo = $this->getDoctrine()->getRepository(Article::class);

        $article = $repo->find($id);
        return $this->render('blog/show.html.twig');
    }
}
