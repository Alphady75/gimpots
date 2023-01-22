<?php

namespace App\Twig;

use App\Repository\PostRepository;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class AppExtension extends AbstractExtension
{
    private $postRepository;

    public function __construct(PostRepository $postRepository){
        $this->postRepository = $postRepository;
    }

    public function getFilters(): array
    {
        return [
            // If your filter generates SAFE HTML, you should add a third
            // parameter: ['is_safe' => ['html']]
            // Reference: https://twig.symfony.com/doc/2.x/advanced.html#automatic-escaping
            new TwigFilter('filter_name', [$this, 'doSomething']),
        ];
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('lastposts', [$this, 'getLastPosts']),
        ];
    }

    public function doSomething($value)
    {
        // ...
    }

    public function getLastPosts()
    {
        return $this->postRepository->findBy([
            'online' => 1
        ], ['id' => 'DESC'], 3);
    }
}
