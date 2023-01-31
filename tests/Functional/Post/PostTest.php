<?php

namespace App\Tests\Functional\Post;

use App\Entity\Post\Post;
use App\Repository\Post\PostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class PostTest extends WebTestCase 
{
    public function testPostPageWorks(): void
    {
        $client = static::createClient();

        /** @var UrlGeneratorInterface */
        $urlGeneratorInterface = $client->getContainer()->get('router');

        /** @var EntityManagerInterface */
        $entityManager = $client->getContainer()->get('doctrine.orm.entity_manager');
        
        /** @var PostRepository */
        $postRepository = $entityManager->getRepository(Post::class);

        /** @var Post */
        $post = $postRepository->findOneBy([]);

        $client->request(
            Request::METHOD_GET,
            $urlGeneratorInterface->generate('post_showArticles', ['slug' => $post->getSlug()])
        );

        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);

        $this->assertSelectorExists('h1');
        $this->assertSelectorTextContains('h1', ucfirst($post->getTitle()));
    }

    public function testReturnToBlogWorks(): void
    {
        $client = static::createClient();

        /** @var UrlGeneratorInterface */
        $urlGeneratorInterface = $client->getContainer()->get('router');

        /** @var EntityManagerInterface */
        $entityManager = $client->getContainer()->get('doctrine.orm.entity_manager');
        
        /** @var PostRepository */
        $postRepository = $entityManager->getRepository(Post::class);

        /** @var Post */
        $post = $postRepository->findOneBy([]);

        $crawler = $client->request(
            Request::METHOD_GET,
            $urlGeneratorInterface->generate('post_showArticles', 
            ['slug' => $post->getSlug()])
        );

        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);

        $link = $crawler->selectLink('Retourner au blog')->link()->getUri();

        $crawler = $client->request(REQUEST::METHOD_GET, $link);

        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $this->assertRouteSame('post_index');
    }

    public function testShareOnFacebookWorks(): void
    {
        $client = static::createClient();

        /** @var UrlGeneratorInterface */
        $urlGeneratorInterface = $client->getContainer()->get('router');

        /** @var EntityManagerInterface */
        $entityManager = $client->getContainer()->get('doctrine.orm.entity_manager');
        
        /** @var PostRepository */
        $postRepository = $entityManager->getRepository(Post::class);

        /** @var Post */
        $post = $postRepository->findOneBy([]);

        $postLink = $urlGeneratorInterface->generate('post_showArticles', 
        ['slug' =>$post->getSlug()]);

        $crawler = $client->request(
            Request::METHOD_GET,
            $postLink
        );

        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);

        $link = $crawler->filter('.share.facebook')->link()->getUri();

        $this->assertStringContainsString(
            "https://www.facebook.com/sharer/sharer.php",
            $link
        );

        $this->assertStringContainsString(
            $postLink,
            $link
        );
    }

    public function testShareOnTwitterWorks(): void
    {
        $client = static::createClient();

        /** @var UrlGeneratorInterface */
        $urlGeneratorInterface = $client->getContainer()->get('router');

        /** @var EntityManagerInterface */
        $entityManager = $client->getContainer()->get('doctrine.orm.entity_manager');
        
        /** @var PostRepository */
        $postRepository = $entityManager->getRepository(Post::class);

        /** @var Post */
        $post = $postRepository->findOneBy([]);

        $postLink = $urlGeneratorInterface->generate('post_showArticles', 
        ['slug' =>$post->getSlug()]);

        $crawler = $client->request(
            Request::METHOD_GET,
            $postLink
        );

        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);

        $link = $crawler->filter('.share.twitter')->link()->getUri();

        $this->assertStringContainsString(
            "https://twitter.com/intent/tweet",
            $link
        );

        $this->assertStringContainsString(
            $postLink,
            $link
        );
    }
}