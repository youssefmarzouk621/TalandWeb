<?php

namespace PostsBundle\Controller;

use PostsBundle\Entity\Posts;
use PostsBundle\Form\PostsType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class PostsController extends Controller
{
    public function AddPostAction(Request $request)
    {
        $post=new Posts();/*instancier un club*/
        $post->setDatecreation(new \DateTime());
        $Form=$this->createForm(PostsType::class,$post);/*creation formulaire || $club bch ye5ou ml objet heka lkol*/
        $Form->handleRequest($request);/*controller le comportement de formulaire||verifier si le formulaire elle ete soumis ou nn || garder une session de formulaire */

        if ($Form->isSubmitted()&&$Form->isValid())/*verifier */
        {
            $em=$this->getDoctrine()->getManager();/*on fait ça pour qu'on peut utiliser les fonction du entity manager l persist w flush*/
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
            'result' => $posts
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

}
