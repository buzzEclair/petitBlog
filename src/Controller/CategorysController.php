<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CategorysRepository;
use App\Repository\ArticlesRepository;
use App\Entity\Categorys;

class CategorysController extends AbstractController
{
    /**
     * @Route("/categorys/{id}", name="category_show")
     */
    public function index(Categorys $categorys, ArticlesRepository $repoArticle)
    {

        $articles = $repoArticle->findByCategorys($categorys);

        return $this->render('categorys/index.html.twig', [
            'articles' => $articles,
        ]);
    }
}
