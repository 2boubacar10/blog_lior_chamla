<?php

namespace App\Controller;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BlogController extends AbstractController
{
    /**
     * @Route("/blog", name="blog")
     */
    public function index(ArticleRepository $repo): Response
    {
        //$repo = $this->getDoctrine()->getRepository(Article::class);

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
     * @Route("/blog/new", name="blog_create")
     */
    public function create(Request $request, ObjectManager $manager){
        dump($request);
        return $this->render('blog/create.html.twig');
    }


    /**
     * @Route("/blog/{id}", name="blog_show")
     */
    public function show(
        Article $article
        //$id
        ){
            //ParamConverter
        //$repo = $this->getDoctrine()->getRepository(Article::class);
        //$article = $repo->find($id);

        return $this->render('blog/show.html.twig', [
            'article' => $article
        ]);
    }

    
}
