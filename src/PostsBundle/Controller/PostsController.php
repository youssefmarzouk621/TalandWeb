<?php

namespace PostsBundle\Controller;

use mysql_xdevapi\Result;
use PostsBundle\Entity\Comments;
use PostsBundle\Entity\Likes;
use PostsBundle\Entity\Posts;
use PostsBundle\Form\PostsType;
use PostsBundle\PostsBundle;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use PostsBundle\Repository\PostsRepository;

class PostsController extends Controller
{
    public function AddPostAction(Request $request)
    {
        $post=new Posts();
        $post->setIdu($this->getUser());
        $post->setDatecreation(new \DateTime());
        $post->setNbrlikes(0);
        $post->setNbrcomments(0);
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

    public function AddPAction($img,$des,Request $request)
    {
        $post=new Posts();
        $post->setDatecreation(new \DateTime());
        $post->setIdu($this->getUser());
        $post->setNbrlikes(0);
        $post->setNbrcomments(0);
        $post->setImageName($img);
        $post->setDescription($des);


        $em=$this->getDoctrine()->getManager();
        $em->persist($post);
        $em->flush();



        return new JsonResponse("img :".$img." des : ".$des);
    }

    public function GetPostsAction()
    {

        $em = $this->getDoctrine()->getManager();
        $posts = $em->getRepository("PostsBundle:Posts")->findAll();
        $likes = $em->getRepository("PostsBundle:Posts")->getLikes();


        return $this->render('@Posts/Posts/get_posts.html.twig', array(
            'result' => $posts,
            'likes' => $likes,
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
    public function RemovePAction($id)
    {
        $em=$this->getDoctrine()->getManager();
        $post=$em->getRepository(Posts::class)->find($id);
        $em->remove($post);
        $em->flush();

        return new JsonResponse("deleted");
    }

    public function ReactAction($idp,$react){
        $em=$this->getDoctrine()->getManager();
        $result=$em->getRepository(Posts::class)->VerifUserLiked($idp,$this->getUser()->getId());
        if ($result!=0){
            return new JsonResponse("exists");
        }else{
            $like=new Likes();
            $like->setIdpost($idp);
            $like->setIdu($this->getUser());
            $like->setDatecreation(new \DateTime());
            $like->setReact($react);
            $em->persist($like);
            $em->flush();
            return new JsonResponse("added");
        }
    }
    public function RemoveLikeAction($id){
        $em=$this->getDoctrine()->getManager();
        $result=$em->getRepository(Posts::class)->GetPostLike($id,$this->getUser()->getId());
        $like=$em->getRepository(Likes::class)->find($result->getIdlike());
        $em->remove($like);
        $em->flush();
        return new JsonResponse("removed ?");
    }

    public function SinglePostAction($id)
    {
        $em=$this->getDoctrine()->getManager();
        $post=$em->getRepository(Posts::class)->find($id);
        $comments=$em->getRepository(Posts::class)->GetPostComments($id);
        $reacts=$em->getRepository(Posts::class)->GetPostReacts($id);

        return $this->render('@Posts/Posts/single_post.html.twig', array(
            'single_post' => $post,
            'comments' => $comments,
            'reacts' => $reacts,
            'connected' => $this->getUser()
        ));
    }
    public function AddCommentAction($id,$contenu)
    {
        $comment=new Comments();
        $comment->setDatecreation(new \DateTime());
        $comment->setEtat(0);
        $comment->setContenu($contenu);
        $emanager=$this->getDoctrine()->getManager();
        $post=$emanager->getRepository(Posts::class)->find($id);

        $comment->setIdpost($post);
        $comment->setIdu($this->getUser());

        $em=$this->getDoctrine()->getManager();
        $em->persist($comment);
        $em->flush();
        return new JsonResponse("comment added");
    }
}
