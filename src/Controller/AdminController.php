<?php

namespace App\Controller;

use App\Entity\Articles;
use App\Entity\Categorys;
use App\Form\ArticlesType;
use App\Form\CategorysType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\ArticlesRepository;
use App\Repository\CategorysRepository;

/**
 * @IsGranted("ROLE_ADMIN")
 */
class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(ArticlesRepository $repo, CategorysRepository $repoCat)
    {
        $articles = $repo->findAll();
        $categorys = $repoCat->findAll();

        return $this->render('admin/index.html.twig', [
            'articles' => $articles,
            'categorys' => $categorys
        ]);
    }

    /**
     * @Route("/admin/article", name="new_article")
     *
     * @return void
     */
    public function newArticle(Request $request, ObjectManager $manager){

        $article = new Articles();
        $form = $this->createForm(ArticlesType::class, $article);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            
            $article->setAuthor($this->getUser());

            $manager->persist($article);
            $manager->flush();

            return $this->redirectToRoute('article_show', [
                'id' => $article->getId()
            ]);
        }

        return $this->render('admin/newArticle.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/article/{id}/edit", name="edit_article")
     *
     * @return void
     */
    public function editArticle(Request $request, ObjectManager $manager, Articles $article){

        $form = $this->createForm(ArticlesType::class, $article);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            
            $article->setAuthor($this->getUser());

            $manager->persist($article);
            $manager->flush();

            return $this->redirectToRoute('admin');
        }

        return $this->render('admin/editArticle.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     *
     * @Route("/admin/article/{id}/delete", name="delete_article")
     * 
     * @return Response
     */
    public function deleteArticle(Articles $article, ObjectManager $manager){

        $manager->remove($article);
        $manager->flush();

        return $this->redirectToRoute('admin');
    }

    /**
     * @Route("/admin/category", name="new_category")
     *
     * @return void
     */
    public function newCategory(Request $request, ObjectManager $manager){

        $category = new Categorys();
        $form = $this->createForm(CategorysType::class, $category);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $manager->persist($category);
            $manager->flush();

            return $this->redirectToRoute('admin');
        }

        return $this->render('admin/newCategory.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/category/{id}/edit", name="edit_category")
     *
     * @return void
     */
    public function editCategory(Request $request, ObjectManager $manager, Categorys $category){

        $form = $this->createForm(CategorysType::class, $category);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $manager->persist($category);
            $manager->flush();

            return $this->redirectToRoute('admin');
        }

        return $this->render('admin/editCategory.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
