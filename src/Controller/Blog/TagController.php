<?php

namespace App\Controller\Blog;

use App\Entity\Tag;
use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/etiquettes')]
class TagController extends AbstractController 
{
    #[Route('/{slug}', name: 'tag_index', methods: ['GET'])]
    public function index(
        Tag $tag,
        PostRepository $postRepository,
        Request $request
        ): Response
    {
        $posts = $postRepository->
        findPublished(
            $request->query->getInt('page', 1), 
            null, 
            $tag);

        return $this->render('pages/tag/index.html.twig', [
            'tag' =>$tag,
            'posts' => $posts
        ]);
    }

}

