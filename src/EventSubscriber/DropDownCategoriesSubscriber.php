<?php

namespace App\EventSubscriber;

use App\Repository\CategoryRepository;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Twig\Environment;

class DropDownCategoriesSubscriber implements EventSubscriberInterface
{
    public const ROUTES = ['post_index', 'category_index'];

    public function __construct(
        private CategoryRepository $categoryRepository,
        private Environment $twig
    ) {
    }


    public function injectGlobalVariable(RequestEvent $event): void
    {
        $route = $event->getRequest()->get('_route');
        if (in_array($route, DropDownCategoriesSubscriber::ROUTES)) {
            $categories = $this->categoryRepository->findAll();
            $this->twig->addGlobal('allCategories', $categories);
        }
    }

    public static function getSubscribedEvents()
    {
        return [KernelEvents::REQUEST => 'injectGlobalVariable'];
    }
}
