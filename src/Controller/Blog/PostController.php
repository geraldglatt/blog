<?php

namespace App\Controller\Blog;

use App\Entity\Tag;
use App\Entity\Post;
use App\Form\SearchType;
use App\Model\SearchData;
use App\Repository\PostRepository;
use App\Repository\TagRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PostController extends AbstractController 
{
    #[Route('/', name: 'post_index', methods: ['GET'])]
    public function index(
        PostRepository $postRepository,
        Request $request
        ): Response
    {
        $searchData = new SearchData();
        $form = $this->createForm(SearchType::class, $searchData);

        $form ->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $searchData->page = $request->query->getInt('page', 1);
            $posts = $postRepository->findBySearch($searchData);

            return $this->render('pages/blog/index.html.twig', [
                'form' => $form->createView(),
                'posts' => $posts
            ]);
        }

        $posts = $postRepository->findPublished(
            $request->query->getInt('page',1));

        return $this->render('pages/blog/index.html.twig', [
            'form' => $form->createView(),
            'posts' =>$posts,
        ]);
    }

    #[Route('/article/{slug}', name: 'post_showArticles', methods: ['GET'])]
    public function showArticles(
        Post $post,
        ): Response
    {
        return $this->render('pages/blog/showArticles.html.twig',[
            'post' =>$post
        ]);
    }
}