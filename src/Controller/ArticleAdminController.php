<?php

namespace App\Controller;

use App\Entity\Article;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;


class ArticleAdminController extends AbstractController
{
    /**
     * @IsGranted("ROLE_ADMIN_ARTICLE")
     * 
     * @Route("/admin/article/new", name="admin_article_new")
     */
    public function new(EntityManagerInterface $em)
    {
        die('todo');
    }

    /**
     * @IsGranted("MANAGE", subject="article")
     * 
     * @Route("/admin/article/{id}/edit")
     */
    public function edit(Article $article)
    {
        //$this->denyAccessUnlessGranted('MANAGE', $article);

        dd($article);
    }
}
