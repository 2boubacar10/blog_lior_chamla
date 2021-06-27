<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Comment;
use App\Form\CommenType;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
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
     * @Route("/blog/{id}/edit", name="blog_edit")
     */
    public function form(Article $article=null, Request $request, ManagerRegistry $manager){

        $manager = $manager->getManager();

        if(!$article){
            $article = new Article();
        }

        /*$form = $this->createFormBuilder($article)
                ->add('title')
                ->add('content')
                ->add('image')
                ->getForm();*/

        $form = $this->createForm(ArticleType::class, $article);

        $form->handleRequest($request);
        //dump($article);


        if($form->isSubmitted() && $form->isValid()){
            if(!$article->getId()){
                $article->setCreatedAt(new \DateTimeImmutable());
            }
            

            $manager->persist($article);
            $manager->flush();


            return $this->redirectToRoute('blog_show', [
                'id' => $article->getId()
            ]);
        }
        /*
        $form = $this->createFormBuilder($article)
                ->add('title', TextType::class, [
                    'attr' => [
                        'placeholder' => "Titre de l'article"
                    ]
                ])
                ->add('content', TextareaType::class, [
                    'attr' => [
                        'placeholder' => "Contenu de l'article"
                    ]
                ])
                ->add('image')
                
                ->add('save', SubmitType::class, [
                    'label' => "Enregistrer"
                ])
                ->getForm();
        */

        return $this->render('blog/create.html.twig', [
            'formArticle' => $form->createView(),
            'editMode' => $article->getId() !== null
        ]);
        /*if($request->request->count() > 0){
            $article = new Article();
            $article->setTitle($request->request->get('title'))
                ->setContent($request->request->get('content'))
                ->setImage($request->request->get('http://placehold.it/350x150'))
                ->setCreatedAt(new \DateTimeImmutable())
                ;

            $manager->getManager()->persist($article);
            $manager->getMnager()->flush();

            return $this->redirectToRoute(
                'blog_show',
                [
                    'id' => $article->getId()
                ]
            );
        }*/
        
        //return $this->render('blog/create.html.twig');
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

        $comment = new Comment();

        $form = $this->createForm(CommenType::class, $comment);

        return $this->render('blog/show.html.twig', [
            'article' => $article,
            'commentForm' => $form->createView()
        ]);
    }

    
}
