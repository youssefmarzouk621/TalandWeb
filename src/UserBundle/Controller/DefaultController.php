<?php

namespace UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function ProfileAction($username)
    {
/*
        $em = $this->getDoctrine()->getManager();
        $posts = $em->getRepository("PostsBundle:Posts")->findAll();
        $likes = $em->getRepository("PostsBundle:Posts")->getLikes();
        $stories = $em->getRepository("PostsBundle:Posts")->getStoriesDistinct();
*/
        return $this->render('@User/Default/profile.html.twig', array(
            /*'result' => $posts,
            'likes' => $likes,
            'stories' => $stories,
            'connected' => $this->getUser()*/
        ));
    }
}
