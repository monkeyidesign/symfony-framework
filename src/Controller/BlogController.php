<?php

namespace App\Controller;

use App\Entity\BlogPost;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Serializer;


/**
 * @Route("/blogs")
 */
class BlogController extends AbstractController
{
    /**
     * @Route("/{page}", name="blog_list", defaults={"page" : 3}, requirements={"page"="\d+"})
     * @param $page
     * @param Request $request
     * @return JsonResponse
     */
    public function list($page, Request $request)
    {
        $limit = $request->get('limit', 10);
        $repository = $this->getDoctrine()->getRepository(BlogPost::class);
        $item = $repository->findAll();
        //var_dump($item);

        $posts = $this->json(
            [
                'page' => $page,
                'limit' => $limit,
                'data' => array_map(function (BlogPost $item){
                    return $this->generateUrl('blog_by_slug',['slug' => $item->getSlug()]);
                }, $item)
            ]
        );
//        return $this->render('blog/index.html.twig', [
//            'controller_name' => 'BlogController',
//            'posts' => $posts
//        ]);

        return $posts;
    }

//    /**
//     * @Route("/post/{id}", name="blog_by_id", requirements={"id"="\d+"})
//     * @param $id
//     * @return JsonResponse
//     */
//    public function post($id){
//        return $this->json(
//            $this->getDoctrine()->getRepository(BlogPost::class)->find($id)
//        );
//    }
    /**
     * @Route("/post/{id}", name="blog_by_id", requirements={"id"="\d+"}, methods={"Get"})
     * @param BlogPost $post
     * @return JsonResponse
     */
    public function post(BlogPost $post){
        return $this->json($post);
    }


//    /**
//     * @Route("/post/{slug}", name="blog_by_slug")
//     * @param $slug
//     * @return JsonResponse
//     */
//    public function postBySlug($slug){
//        return $this->json(
//            $this->getDoctrine()->getRepository(BlogPost::class)->findOneBy(['slug' => $slug])
//        );
//    }
    /**
     * @Route("/post/{slug}", name="blog_by_slug", methods={"Get"})
     * @param BlogPost $post
     * @return JsonResponse
     */
    public function postBySlug(BlogPost $post){
        return $this->json($post);
    }


    /**
     * @Route("/add", name="blog_add", methods={"POST"})
     * @param Request $request
     * @return JsonResponse
     */
    public function add(Request $request){

        /** @var Serializer $serializer*/
        $serializer = $this->get('serializer');

        $blogPost = $serializer->deserialize($request->getContent(),BlogPost::class,'json');
        $em = $this->getDoctrine()->getManager();
        $em->persist($blogPost);
        $em->flush();

        return $this->json($blogPost);
    }
}
