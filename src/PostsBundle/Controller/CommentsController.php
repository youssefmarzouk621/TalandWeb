<?php

namespace PostsBundle\Controller;

use PostsBundle\Entity\Comments;
use PostsBundle\Entity\Posts;
use PostsBundle\Form\CommentsType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CommentsController extends Controller
{
    public function AddCommentAction($id,$contenu)
    {/*
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
        $em->flush();*/
        return new JsonResponse("comment added");
    }

    public function GetCommentsAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $comments = $em->getRepository("PostsBundle:Comments")->findBy(array('idpost' => $id));
        return $this->render('@Posts/Comments/get_comments.html.twig', array(
            'result' => $comments
        ));
    }

    public function DeleteCommentAction($id,$idc)
    {
        $em=$this->getDoctrine()->getManager();
        $comment=$em->getRepository(Comments::class)->find($idc);
        $em->remove($comment);
        $em->flush();
        return $this->redirectToRoute('single_post', array('id' => $id));
    }

    public function UpdateCommentAction($id,$idc,Request $request)
    {
        $em=$this->getDoctrine()->getManager();
        $comment=$em->getRepository(Comments::class)->find($idc);
        $comment->setDatecreation(new \DateTime());
        $comment->setEtat(1);
        $Form=$this->createForm(CommentsType::class,$comment);
        $Form->handleRequest($request);
        if ($Form->isSubmitted())
        {
            $em->flush();
            return $this->redirectToRoute('get_comments', array('id' => $id));
        }
        return $this->render('@Posts/Comments/update_comment.html.twig', array(
            'commentform'=>$Form->createView()
        ));
    }

}
