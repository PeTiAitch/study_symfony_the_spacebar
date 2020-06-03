<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController
{
    /**
     * @Route("/", name="homepage")
     */
    public function homepage()
    {
        return new Response('This is my homepage!');
    }

    /**
     * @Route("/show/{slug}")
     */
    public function show($slug)
    {
        return new Response(sprintf(
            'Future page to show one space article: %s',
            $slug)
        );
    }
}