<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/blogs")
 */
class BlogController extends AbstractController
{
    private const POSTS = [
        [
            'id' => 1,
            'slug' => 'first-post',
            'title' => 'First Post'
        ],
        [
            'id' => 2,
            'slug' => 'another-post',
            'title' => 'This is another post!'
        ],
        [
            'id' => 3,
            'slug' => 'last-post',
            'title' => 'This is the last post'
        ]
    ];

    /**
     * @Route("/{page}", name="blog_list", defaults={"page" : 3})
     * @param $page
     * @param Request $request
     * @return JsonResponse
     */
    public function list($page, Request $request)
    {
        $limit = $request->get('limit', 10);
        $posts = $this->json(
            [
                'page' => $page,
                'limit' => $limit,
                'data' => array_map(function ($item){
                    return $this->generateUrl('blog_by_slug',['slug' => $item['slug']]);
                }, self::POSTS)
            ]
        );
//        return $this->render('blog/index.html.twig', [
//            'controller_name' => 'BlogController',
//            'posts' => $posts
//        ]);

        return $posts;
    }

    /**
     * @Route("/post/{id}", name="blog_by_id", requirements={"id"="\d+"})
     * @param $id
     * @return JsonResponse
     */
    public function post($id){
        return $this->json(
            self::POSTS[array_search($id, array_column(self::POSTS, 'id'))]
        );
    }

    /**
     * @Route("/post/{slug}", name="blog_by_slug")
     * @param $slug
     * @return JsonResponse
     */
    public function postBySlug($slug){
        return $this->json(
            self::POSTS[array_search($slug, array_column(self::POSTS, 'slug'))]
        );
    }
}
