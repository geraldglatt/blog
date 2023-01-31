<?php

namespace App\Controller\Blog;

use App\Repository\Post\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PostController extends AbstractController 
{
    #[Route('/', name: 'post_index', methods: ['GET'])]
    public function index(
        PostRepository $postRepository,
        Request $request
        ): Response
    {
        $posts = $postRepository->findPublished($request->query->getInt('page',1));

        return $this->render('pages/blog/index.html.twig', [
            'posts' =>$posts
        ]);
    }

    #[Route('/articles/{slug}', name: 'post_showArticles', methods: ['GET'])]
    public function showArticles(String $slug): Response
    {
        return $this->render('pages/blog/showArticles.html.twig');
    }
}