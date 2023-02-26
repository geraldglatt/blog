<?php

namespace App\Controller;

use App\Entity\Post;
use App\Entity\User;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LikeController extends AbstractController 
{
    #[Route('/like/article/{id}', name: 'like_post')]
    public function like(Post $post, EntityManagerInterface $manager):Response
    {
        $user = $this->getUser();

        if($post->isLikedByUser($user)) {
            $post->removeLike($user);
            $manager->flush();

            return $this->json(['message' => 'Le like a bien été supprimé !']);
        }

        $post->addLike($user);
        $manager->flush();
        return $this->json(['message' => 'Le like a bien été ajouté !']);

    }
}