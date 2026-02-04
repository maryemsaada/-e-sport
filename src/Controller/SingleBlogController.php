<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class SingleBlogController extends AbstractController
{
    #[Route('/single/blog', name: 'app_single_blog')]
    public function index(): Response
    {
        return $this->render('single_blog/index.html.twig', [
            'controller_name' => 'SingleBlogController',
        ]);
    }
}
