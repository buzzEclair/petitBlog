<?php

namespace App\Controller;

use App\Entity\Articles;
use App\Repository\ArticlesRepository;
use App\Repository\CategorysRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class ArticlesController extends AbstractController
{
    /**
     * @Route("/", name="blog")
     */
    public function index(ArticlesRepository $repo, CategorysRepository $repoCat, Request $request, PaginatorInterface $paginator)
    {

        $articles = $repo->findAll();
        $categorys = $repoCat->findAll();

        $pagination = $paginator->paginate($articles, $request->query->getInt('page', 1), 3 );
        
        return $this->render('articles/index.html.twig', [
            'articles' => $articles,
            'categorys' => $categorys,
            'pagination' => $pagination
        ]);
    }

    /**
     * @Route("/article/{id}", name="article_show")
     */
    public function ArticleShow(Articles $article, CategorysRepository $repoCat)
    {
        $categorys = $repoCat->findById($article->getCategorys());

        return $this->render('articles/show.html.twig', [
            'article' => $article,
            'categorys' => $categorys
        ]);
    }
}
