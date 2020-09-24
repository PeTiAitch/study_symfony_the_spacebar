<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleFormType;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;

class ArticleAdminController extends BaseController
{
    /**
     * @IsGranted("ROLE_ADMIN_ARTICLE")
     * 
     * @Route("/admin/article/new", name="admin_article_new")
     */
    public function new(EntityManagerInterface $em, Request $request)
    {
        $form = $this->createForm(ArticleFormType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var Article $article */
            $article = $form->getData();

            $em->persist($article);
            $em->flush();
            $this->addFlash('success', 'Article created! Knowledge is power!');

            return $this->redirectToRoute('admin_article_list');
        }

        return $this->render('article_admin/new.html.twig', [
            'articleForm' => $form->createView(),
        ]);
    }

    /**
     * @IsGranted("MANAGE", subject="article")
     * 
     * @Route("/admin/article/{id}/edit", name="admin_article_edit")
     */
    public function edit(Article $article, Request $request, EntityManagerInterface $em)
    {
        $form = $this->createForm(ArticleFormType::class, $article, [
            'include_published_at' => true
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            $this->addFlash('success', 'Article updated! Inaccuracies squashed!');

            return $this->redirectToRoute('admin_article_edit', [
                'id' => $article->getId(),
            ]);
        }

        return $this->render('article_admin/edit.html.twig', [
            'articleForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/article", name="admin_article_list")
     */
    public function list(ArticleRepository $aricleRepo)
    {
        $articles = $aricleRepo->findAll();

        return $this->render('article_admin/list.html.twig', [
            'articles' => $articles
        ]);
    }

    /**
     * @IsGranted("ROLE_USER")
     * 
     * @Route("/admin/article/location-select", name="admin_article_location_select")
     */
    public function getSpecificLocationSelect(Request $request)
    {
        if (!$this->isGranted('ROLE_ADMIN_ARTICLE') && $this->getUser()->getArticles()->isEmpty()) {
            throw $this->createAccessDeniedException();
        }


        $article = new Article();
        $article->setLocation($request->query->get('location'));

        $form = $this->createForm(ArticleFormType::class, $article);

        if (!$form->has('specificLocationName')) {
            return new Response(null, 204);
        }

        return $this->render('article_admin/_specific_location_name.html.twig', [
            'articleForm' => $form->createView()
        ]);
    }
}
