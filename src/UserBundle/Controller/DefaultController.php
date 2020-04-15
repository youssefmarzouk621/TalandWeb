<?php

namespace UserBundle\Controller;

use PostsBundle\Entity\Posts;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    public function ProfileAction($username)
    {

        $em = $this->getDoctrine()->getManager();
        $profile=$em->getRepository(Posts::class)->getprofileuser($username);
        $posts=$em->getRepository(Posts::class)->findBy(['idu' => $profile[0]['id'],'archive' => 0,'type' => 0 ]);

        return $this->render('@User/Default/profile.html.twig', array(
            'profile' => $profile[0],
            'posts' => $posts
        ));
    }
}
