<?php

namespace NewsBundle\Controller;

use Gregwar\Captcha\CaptchaBuilder;
use NewsBundle\Entity\News;
use NewsBundle\Entity\review;
use NewsBundle\Form\NewsType;
use NewsBundle\Form\reviewType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use UserBundle\Entity\User;


class NewsController extends Controller
{
    public function showArticleAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $listearticles = $em->getRepository('NewsBundle:News')->findAll();

        /**
         * @var $paginator\Knp\Component\Pager\Paginator
         */
        $paginator  = $this->get('knp_paginator');

        $articles= $paginator->paginate(
            $listearticles,
            $request->query->get('page', 1)/*le numéro de la page à afficher*/,
            3/*nbre d'éléments par page*/
        );
        return $this->render('@News/News/Article_back.html.twig', array(
            'article' => $articles,
        ));
    }
    public function showArticlefrontAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $queryBuilder = $em->getRepository('NewsBundle:News')->createQueryBuilder('bp');


        $queryBuilder->orderBy("bp.dateArticle", 'DESC');
        if ($request->query->getAlnum('filter')){
            $queryBuilder
                ->where('bp.nomArticle LIKE :nomArticle')
                ->setParameter('nomArticle','%' . $request->query->getAlnum('filter') . '%');

        }
        $article=$queryBuilder->getQuery();

        /**
         * @var $paginator\Knp\Component\Pager\Paginator
         */
        $paginator  = $this->get('knp_paginator');

        $articles= $paginator->paginate(
            $article,
            $request->query->get('page', 1)/*le numéro de la page à afficher*/,
            9/*nbre d'éléments par page*/
        );


        return $this->render ("@News/News/Article_front.html.twig",array('articles'=>$articles));

    }



    public function newArticleAction(Request $request)
    {

        $membre=$this->container->get('security.token_storage')->getToken()->getUser()->getId();

        $article = new News();

        $form = $this->createForm(NewsType::class,$article);
        $form = $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

                $file= $request->files->get('newsbundle_news')['imageArticle'];
                $uploads_directory=$this->getParameter('uploads_directory');
    
                var_dump($file);
    
                $imageArticle=$file->getClientoriginalName();
                $em = $this->getDoctrine()->getManager();
    
                $file->move($uploads_directory,$imageArticle);
            $article->setImageArticle($imageArticle);
            $article->setIdUser($membre);

            $a=date('H:i:s d/m/Y');

            $article->setDateArticle($a);
            $b=0;
            $article->setNbrevue($b);

            $em->persist($article);
            $em->flush();
            return $this->redirect($this->generateUrl(
                "showArticle", ['id' => $article->getIdArticle()]
            ));
        }
        return $this->render('@News/News/Article_back_Add.html.twig',array('form' => $form->createView()));
    }

    public function deleteArticleAction($id) {
        $em = $this->getDoctrine()->getManager();
        $article = $em->getRepository(News::class)->find($id);
        $em->remove($article);
        $em->flush();
        return $this->redirectToRoute("showArticle");
    }

    public function editArticleAction($id , Request $request) {
        $article = new News();
        $em = $this->getDoctrine()->getManager();
        $article = $em->getRepository(News::class)->find($id);
        $form = $this->createForm(NewsType::class,$article);
        $form = $form->handleRequest($request);
        if ($form->isSubmitted())
        {


            $file= $request->files->get('newsbundle_news')['imageArticle'];
            $uploads_directory=$this->getParameter('uploads_directory');
            $imageArticle=$file->getClientoriginalName();
            $file->move($uploads_directory,$imageArticle);
            $article->setImageArticle($imageArticle);
            $a=date('H:i:s d/m/Y');
            $article->setDateArticle($a);
            $em->persist($article);
            $em->flush();
            return $this->redirectToRoute("showArticle");
        }
        return $this->render('@News/News/Article_back_Modifier.html.twig',array('form' => $form->createView()));


    }
    public function articleAction($id,Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        $article = $em->getRepository(News::class)->find($id);
        $art = $em->getRepository(News::class)->findAll();
        $article->setnbrevue($article->getnbrevue()+1);
        $em->persist($article);
        $em->flush();
        $ar = $em->getRepository(User::class)->find($article->getIduser());

        $events= $em->getRepository(\NewsBundle\Entity\News::class)->findAll();
        $sql="select * from news order by nbrevue desc limit 3";
        $result=$em->getConnection()->prepare($sql);
        $result->execute();
        $statement = $result->fetchAll();
        dump($statement);

        $em = $this->getDoctrine()->getManager();

        $reviews = $em->getRepository('NewsBundle:review')->findBy([
            "idarticle"=>$id
        ]);

        $review=new review();
        $review->setEtat(1);
        $Form=$this->createForm(reviewType::class,$review);
        $Form->handleRequest($request);
        if ($Form->isSubmitted()&&$Form->isValid())
        {
            $em=$this->getDoctrine()->getManager();
            $user = $this->getUser();
            $review->setIduser($user);
            $review->setEtat(1);
            $review->setIdarticle($article);
            $em->persist($review);
            $em->flush();
            return $this->redirectToRoute('article',array(
                'id' => $id,

            ));
        }


        $repository= $em->getRepository(review::class)->avgrating($id);


        return $this->render("@News/News/article.html.twig",array(
            'article'=>$article,
            'ar'=>$ar,
            'aman'=>$statement,
            'art'=>$art,
            'event'=>$events,
            'review'=> $reviews,
            'reviewform'=>$Form->createView(),
            'avg'=> $repository,
            'etat' =>$review,
        ));
    }

    public function imprimerAction($id) {
        $user=$this->container->get('security.token_storage')->getToken()->getUser();
        $em = $this->getDoctrine()->getManager();
        $news = $em->getRepository(News::class)->find($id);
        return $this->render('@News/News/print.html.twig',array('news'=>$news,'nom'=>$user));
    }



    public function showreviewAction($id)
    {

        $em = $this->getDoctrine()->getManager();
        $article = $em->getRepository(News::class)->find($id);
        $art = $em->getRepository(News::class)->findAll();
        $article->setnbrevue($article->getnbrevue()+1);
        $em->persist($article);
        $em->flush();
        $ar = $em->getRepository(User::class)->find($article->getIduser());

        $events= $em->getRepository(\NewsBundle\Entity\News::class)->findAll();
        $sql="select * from news order by nbrevue desc limit 3";
        $result=$em->getConnection()->prepare($sql);
        $result->execute();
        $statement = $result->fetchAll();
        dump($statement);

        $em = $this->getDoctrine()->getManager();

        $reviews = $em->getRepository('NewsBundle:review')->find($id);




        return $this->render("@News/News/article.html.twig",array(
           'article'=>$article,
            'ar'=>$ar,
            'aman'=>$statement,
            'art'=>$art,
            'event'=>$events,
            'review'=> $reviews

    ));


    }


    public function trinbvueAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $queryBuilder = $em->getRepository('NewsBundle:News')->createQueryBuilder('bp');


        $queryBuilder->orderBy("bp.nbrevue", 'DESC');
        if ($request->query->getAlnum('filter')){
            $queryBuilder
                ->where('bp.nomArticle LIKE :nomArticle')
                ->setParameter('nomArticle','%' . $request->query->getAlnum('filter') . '%');

        }
        $article=$queryBuilder->getQuery();

        /**
         * @var $paginator\Knp\Component\Pager\Paginator
         */
        $paginator  = $this->get('knp_paginator');

        $articles= $paginator->paginate(
            $article,
            $request->query->get('page', 1)/*le numéro de la page à afficher*/,
            9/*nbre d'éléments par page*/
        );






        return $this->render('@News/News/trinbvue.html.twig', array(

            'arttri'=>$articles
        ));



    }

    public function triplusrecentAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $queryBuilder = $em->getRepository('NewsBundle:News')->createQueryBuilder('bp');


        $queryBuilder->orderBy("bp.dateArticle", 'DESC');
        if ($request->query->getAlnum('filter')){
            $queryBuilder
                ->where('bp.nomArticle LIKE :nomArticle')
                ->setParameter('nomArticle','%' . $request->query->getAlnum('filter') . '%');

        }
        $article=$queryBuilder->getQuery();

        /**
         * @var $paginator\Knp\Component\Pager\Paginator
         */
        $paginator  = $this->get('knp_paginator');

        $articles= $paginator->paginate(
            $article,
            $request->query->get('page', 1)/*le numéro de la page à afficher*/,
            9/*nbre d'éléments par page*/
        );






        return $this->render('@News/News/trinbvue.html.twig', array(

            'arttri'=>$articles
        ));



    }

    public function trimoinsrecentAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $queryBuilder = $em->getRepository('NewsBundle:News')->createQueryBuilder('bp');


        $queryBuilder->orderBy("bp.dateArticle", 'ASC');
        if ($request->query->getAlnum('filter')){
            $queryBuilder
                ->where('bp.nomArticle LIKE :nomArticle')
                ->setParameter('nomArticle','%' . $request->query->getAlnum('filter') . '%');

        }
        $article=$queryBuilder->getQuery();

        /**
         * @var $paginator\Knp\Component\Pager\Paginator
         */
        $paginator  = $this->get('knp_paginator');

        $articles= $paginator->paginate(
            $article,
            $request->query->get('page', 1)/*le numéro de la page à afficher*/,
            9/*nbre d'éléments par page*/
        );






        return $this->render('@News/News/trinbvue.html.twig', array(

            'arttri'=>$articles
        ));


    }


    public function chartratingAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $rate = $em->getRepository('NewsBundle:review')->avgstatrating();
    dump($rate);


        return $this->render('@News/News/chartrate.html.twig', array(
            'rate' => $rate,

        ));
    }












}
