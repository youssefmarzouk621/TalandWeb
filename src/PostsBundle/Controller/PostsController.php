<?php

namespace PostsBundle\Controller;

use mysql_xdevapi\Result;
use NewsBundle\Entity\review;
use PostsBundle\Entity\Comments;
use PostsBundle\Entity\Likes;

use PostsBundle\Entity\Posts;
use PostsBundle\Entity\Viewer;
use PostsBundle\Form\PostsType;
use PostsBundle\PostsBundle;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

use PostsBundle\Repository\PostsRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use UserBundle\Entity\User;
use Rypsx\Ipapi\Ipapi;

class PostsController extends Controller
{
    public function AddPostAction(Request $request)
    {
        $post=new Posts();
        $post->setIdu($this->getUser());
        $post->setDatecreation(new \DateTime());
        $post->setNbrlikes(0);
        $post->setArchive(0);

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

    public function CaptureAction(Request $request)
    {
        $post=new Posts();
        $post->setIdu($this->getUser());
        $post->setDatecreation(new \DateTime());
        $post->setNbrlikes(0);
        $post->setArchive(0);

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
        return $this->render('@Posts/Posts/capture.html.twig', array(
            'postform'=>$Form->createView()
        ));
    }
    public function AddPAction($img,$des,$type,Request $request)
    {
        $post=new Posts();
        $post->setDatecreation(new \DateTime());
        $post->setIdu($this->getUser());
        $post->setNbrlikes(0);
        $post->setNbrcomments(0);
        $post->setImageName($img);
        $post->setDescription($des);
        $post->setArchive(0);
        $post->setType($type);


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
        $stories = $em->getRepository("PostsBundle:Posts")->getStoriesDistinct();

        //var_dump($likes);
        //var_dump("*****************");
        //var_dump($posts);
        return $this->render('@Posts/Posts/get_posts.html.twig', array(
            'result' => $posts,
            'likes' => $likes,
            'stories' => $stories,
            'connected' => $this->getUser()
        ));
    }

    public function DisplayStoriesAction(){
        $em = $this->getDoctrine()->getManager();
        $storyusers = $em->getRepository("PostsBundle:Posts")->getStoriesDistinct();
        $stories = $em->getRepository("PostsBundle:Posts")->getStories();


        return $this->render('@Posts/Posts/get_stories.html.twig', array(
            'storyusers' => $storyusers,
            'stories' => $stories,
            'connected' => $this->getUser()
        ));


    }

    public function DStoriesAction(){
        $returns=array();
        $em=$this->getDoctrine()->getManager();
        $result=$em->getRepository(Posts::class)->Dstories();

        foreach ($result as $row){
            array_push($returns,$row['idPost']);
        }

        //var_dump($result);
        return new JsonResponse($result);
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
            $post=new Posts();
            $like->setIdpost($idp);
            $like->setIdu($this->getUser());
            $like->setDatecreation(new \DateTime());
            $like->setReact($react);
            $em->persist($like);
            $post->setNbrlikes($post->getNbrlikes()+1);
            $em->flush();
            return new JsonResponse("added");
        }
    }
    public function RemoveLikeAction($id){
        $em=$this->getDoctrine()->getManager();
        $result=$em->getRepository(Posts::class)->GetPostLike($id,$this->getUser()->getId());
        $like=$em->getRepository(Likes::class)->find($result->getIdlike());
        $post=new Posts();
        $post->setNbrlikes($post->getNbrlikes()-1);
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
        $post=new Posts();
        $post->setNbrcomments($post->getNbrcomments()+1);
        $em->persist($comment);
        $em->flush();
        return new JsonResponse("comment added");
    }
 


    public function GetSearchAction(){
        $idc=array();
        $em=$this->getDoctrine()->getManager();
        $result=$em->getRepository(Posts::class)->getdbusers();

        foreach ($result as $row){

            array_push($idc,$row['username']);
        }

        //var_dump($result);
        return new JsonResponse($idc);
    }



    public function GetSearchImgAction(){
        $ids=array();
        $em=$this->getDoctrine()->getManager();
        $result=$em->getRepository(Posts::class)->getdbusers();

        foreach ($result as $row){

            array_push($ids,$row['image_name']);
        }

        //var_dump($idc);
        return new JsonResponse($ids);
    }

    public function GetIpAddressDetailsAction($ip){

        if ($this->getUser()==null){
            return new JsonResponse("not connected");
        }else{
            try {
                $ipapi = new Ipapi($ip);
            } catch (\Exception $e) {
                print $e->getMessage();
            }
            return new JsonResponse($ipapi);
        }

    }

    public function AddViewersAction($idpost,$address,$operateur,$pays,$region,$ville){

        if ($this->getUser()==null){
            return new JsonResponse("not connected");
        }else{
            $vu = new Viewer();
            $vu->setIdu($this->getUser());
            $vu->setIdpost($idpost);
            $vu->setAddress($address);
            $vu->setDate(new \DateTime());
            $vu->setOperateur($operateur);
            $vu->setPays($pays);
            $vu->setRegion($region);
            $vu->setVille($ville);

            $em=$this->getDoctrine()->getManager();
            $em->persist($vu);
            $em->flush();

            return new JsonResponse("vu");
        }

    }



    /*Mobile*/
    public function getAllPostsAction(){
        $result=$this->getDoctrine()->getManager()->getRepository("PostsBundle:Posts")->findMobile();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $posts=$serializer->normalize($result);
        return new JsonResponse($posts);
    }

    public function getPostLikesAction($idpost){
        $result=$this->getDoctrine()->getManager()->getRepository("PostsBundle:Likes")->findBy(
            ['idpost' => $idpost]
        );
        $serializer = new Serializer([new ObjectNormalizer()]);
        $likes=$serializer->normalize($result);
        return new JsonResponse($likes);
    }


    public function addPostMobileAction($description,$idu,$image,$type,$archive)
    {
        $em = $this->getDoctrine()->getManager();
        $user=$em->getRepository("UserBundle:User")->find($idu);
        $post = new Posts();
        $post->setDescription($description);
        $post->setIdu($user);
        $post->setImageName($image);
        $post->setType($type);
        $post->setArchive($archive);
        $post->setNbrlikes(0);
        $post->setNbrcomments(0);
        $post->setDatecreation(new \DateTime());


        $em->persist($post);
        $em->flush();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($post);
        return new JsonResponse($formatted);

    }


    public function EditPostMobileAction($id,$description,$idu,$image,$type,$archive)
    {
        $em = $this->getDoctrine()->getManager();
        $user=$em->getRepository("UserBundle:User")->find($idu);
        $post =$em->getRepository(Posts::class)->find($id);
        $post->setDescription($description);
        $post->setIdu($user);
        $post->setImageName($image);
        $post->setType($type);
        $post->setArchive($archive);
        $post->setDatecreation(new \DateTime());

        $em->flush();

        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($post);
        return new JsonResponse($formatted);

    }

    public function deletePostMobileAction($id)
    {
        $em=$this->getDoctrine()->getManager();
        $post=$em->getRepository(Posts::class)->find($id);
        $em->remove($post);
        $em->flush();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($post);
        return new JsonResponse($formatted);

    }
}
