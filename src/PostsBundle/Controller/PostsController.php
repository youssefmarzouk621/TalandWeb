<?php

namespace PostsBundle\Controller;

use mysql_xdevapi\Result;
use PostsBundle\Entity\Likes;
use PostsBundle\Entity\Posts;
use PostsBundle\Form\PostsType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use PostsBundle\Repository\PostsRepository;

class PostsController extends Controller
{
    public function AddPostAction(Request $request)
    {
        $post=new Posts();
        $post->setDatecreation(new \DateTime());
        $Form=$this->createForm(PostsType::class,$post);
        $Form->handleRequest($request);

        if ($Form->isSubmitted()&&$Form->isValid())
        {
            $em=$this->getDoctrine()->getManager();
            $em->persist($post);
            $em->flush();
            return $this->redirectToRoute('get_posts');
        }
        return $this->render('@Posts/Posts/add_post.html.twig', array(
            'postform'=>$Form->createView()
        ));
    }

    public function GetPostsAction()
    {
        $em = $this->getDoctrine()->getManager();
        $posts = $em->getRepository("PostsBundle:Posts")->findAll();
        return $this->render('@Posts/Posts/get_posts.html.twig', array(
            'result' => $posts,
            'connected' => $this->getUser()
        ));
    }

    public function UpdatePostAction($id,Request $request)
    {
        $em=$this->getDoctrine()->getManager();
        $post=$em->getRepository(Posts::class)->find($id);
        $post->setDatecreation(new \DateTime());
        $Form=$this->createForm(PostsType::class,$post);
        $Form->handleRequest($request);
        if ($Form->isSubmitted())
        {
            $em->flush();
            return $this->redirectToRoute('get_posts');
        }
        return $this->render('@Posts/Posts/update_post.html.twig', array(
            'postform'=>$Form->createView()
        ));
    }

    public function DeletePostAction($id)
    {
        $em=$this->getDoctrine()->getManager();
        $post=$em->getRepository(Posts::class)->find($id);
        $em->remove($post);
        $em->flush();
        return $this->redirectToRoute('get_posts');
    }


    public function ReactAction($idp,$react){
        $em=$this->getDoctrine()->getManager();
        $result=$em->getRepository(Posts::class)->VerifUserLiked($idp,$this->getUser()->getId());
        if ($result!=0){
            return new JsonResponse("exists");
        }else{
            $like=new Likes();
            $like->setIdpost($idp);
            $like->setIdu($this->getUser()->getId());
            $like->setDatecreation(new \DateTime());
            $like->setReact($react);
            $em->persist($like);
            $em->flush();
            return new JsonResponse("added");
        }
    }
    public function RemoveLikeAction($idp){
        $em=$this->getDoctrine()->getManager();
        $result=$em->getRepository(Posts::class)->GetPostLike($idp,$this->getUser()->getId());
        $em->remove($result);
        $em->flush();
        return new JsonResponse("deleted");



    }

}
