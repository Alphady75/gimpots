<?php

namespace App\Controller;

use App\Entity\Post;
use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class BlogController extends AbstractController
{
    #[Route('/blog', name: 'app_blog')]
    public function posts(PostRepository $postRepository, PaginatorInterface $paginator, Request $request): Response
    {
        $posts = $paginator->paginate(
            $postRepository->findBy(['online' => 1], ['id'    =>  'DESC']),
            $request->query->getInt('page', 1),
            8
        );

        return $this->render('blog/posts.html.twig', [
            'posts' => $posts,
        ]);
    }

    #[Route('/blog/{slug}', name: 'app_blog_detail', methods: ['GET'])]
    public function details(Post $post): Response
    {
        return $this->render('blog/details.html.twig', [
            'post' => $post,
        ]);
    }
}
