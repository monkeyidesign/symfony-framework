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
