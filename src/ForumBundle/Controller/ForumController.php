<?php

namespace ForumBundle\Controller;

use ForumBundle\Entity\Commentaire;
use ForumBundle\Entity\historique;
use ForumBundle\Entity\signaler;
use ForumBundle\Form\signalerType;
use ForumBundle\Form\SujetType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use ForumBundle\Entity\Sujet;
use Snipe\BanBuilder\CensorWords;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use UserBundle\Entity\User;


class ForumController extends Controller
{
    public function affichageforumAction(Request $request) //afficher les sujets
    {
        $user = $this->container->get('security.token_storage')->getToken()->getUser();

        $em = $this->getDoctrine()->getManager();
        $forum = $em->getRepository("ForumBundle:Sujet")->findAll();

        $pagination=$this->get('knp_paginator');
        dump(get_class($pagination));

        $forums  = $this->get('knp_paginator')->paginate(
            $forum,
            $request->query->get('page', 1)/*le numéro de la page à afficher*/,
            2/*nbre d'éléments par page*/
        );

        $censor = new CensorWords;

        return $this->render('@Forum/Forum/listforums.html.twig',array(
            'forums' => $forums,
            'censorF' => $censor,
        ));
    }




    public function mesForumsAction() //afficher les forums de lutulisateur connecte
    {
        $user = $this->getUser();
        $em = $this->getDoctrine()->getManager();
        $forums = $em->getRepository('ForumBundle:Sujet')->findBy([
            "idUser"=>$user
        ]);
        dump($forums);


        return $this->render('@Forum/Forum/mesforums.html.twig',array(
            'forums' => $forums
        ));
    }

    public function supprimerSujetAction($id,Request $request)
    {

        $forum = $this->getDoctrine()->getRepository('ForumBundle:Sujet')->find($id);
        $user=$this->getUser();
        $em =$this->getDoctrine()->getManager();
        $em->remove($forum);
        $em->flush();

        //historique
        $name = $this->getUser()->getUsername();
        $historique=new historique ();
        $historique->setIdu($user);
        $historique->setDescription("User ".$name."deleted a subject");

        return $this->redirectToRoute('afficher_messujets');
    }

    public function modifierSujetAction($id,Request $request)
    {
        $user = $this->getUser();
        $em=$this->getDoctrine()->getManager();
        $forum=$em->getRepository(Sujet::class)->find($id);
        $forum->setDate(new \DateTime("now"));
        $Form=$this->createForm(SujetType::class,$forum);
        $Form->handleRequest($request);
        if ($Form->isSubmitted())
        {
            $forum->setIdUser($user);
            $em = $this->getDoctrine()->getManager();
            $em->persist($forum);
            $em->flush();

            //historique
            $name = $this->getUser()->getUsername();
            $historique=new historique ();
            $historique->setIdu($user);
            $historique->setDescription("User ".$name."modified a subject");


            return $this->redirectToRoute('afficher_messujets');
        }
        return $this->render('@Forum/Forum/modifiersujet.html.twig', array(
            'modifform'=>$Form->createView()
        ));

    }

    public function validersujetAction(Request $request, Sujet $forum)
    {
        $em = $this->getDoctrine()->getManager();
        $forum->setEtat(1);
        $this->getDoctrine()->getManager()->flush();
        $sujet = $em->getRepository('ForumBundle:Sujet')->findBy(array('etat' =>0));
        return $this->redirectToRoute('back_forum', array(
            'sujet' => $sujet,

        ));
    }

    public function refusersujetAction(Request $request, Sujet $forum)
    {
        $em = $this->getDoctrine()->getManager();
        $forum->setEtat(-1);
        $this->getDoctrine()->getManager()->flush();
        $sujet = $em->getRepository('ForumBundle:Sujet')->findBy(array('etat' =>0));
        return $this->redirectToRoute('back_forum', array(
            'sujet' => $sujet,

        ));
    }

    public function reloadbackAction()
    {
        $em = $this->getDoctrine()->getManager();

        $sujet = $em->getRepository('ForumBundle:Sujet')->findBy(array('etat' =>0));
        $nbresujetprop = $em->getRepository('ForumBundle:Sujet')->nbresujetpropse();
      //   dump($nbresujetprop);

        return $this->render('@Forum/Forum/sujetback.html.twig', array(
            'sujet' => $sujet,
            'nbsrep' => $nbresujetprop,

        ));
    }

    public function detailssujetAction(Request $request,$id)
    {
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        $em = $this->getDoctrine()->getManager();
        $forum = $this->getDoctrine()->getRepository('ForumBundle:Sujet')->find($id);
        $comments = $em->getRepository('ForumBundle:Commentaire')->findBy([
            "idF"=>$id
        ]);

        $comment = new Commentaire();
        $form = $this->createFormBuilder($comment)

            ->add('descriptionCom',TextType::class,array('attr'=>array('class'=>'form-control') ))

            ->add('save',SubmitType::class,array('label'=>'Ajouter Comment','attr'=>array('class'=>'btn oneMusic-btn mt-30') ))
            ->getForm();
        $form->handleRequest($request);
        if($form->isSubmitted()&&$form->isValid()) {
            $desc=$form['descriptionCom']->getData();


            $comment->setDescriptionCom($desc);
            $comment->setDateCom(new \DateTime("now"));
            $comment->setIdUser($user);
            $comment->setIdF($forum->getIdF());
            // var_dump($comment);
            $em = $this->getDoctrine()->getManager();

            $em->persist($comment);
            $em->flush();


            return $this->redirectToRoute('detail_sujet',array('id' => $id));
        }
        $em = $this->getDoctrine()->getManager();
        $ancien=$forum->getNbreJaime();

        $forum->setNbreJaime($ancien + 0 );


        $em->persist($forum);
        $em->flush();

        $repository= $em->getRepository(commentaire::class)->nombrecommentaires($forum->getIdF());
    //dump($repository);
    //die();

        return $this->render('@Forum/Forum/detailssujet.html.twig',array(
            'forum' => $forum,
            'comments'=>$comments,
            'user' => $user,
            'nbcom' =>$repository,
            'form'=>$form->createView(),

        ));
    }

    public function amanAction(Request $request,$id)
    {
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        $em = $this->getDoctrine()->getManager();
        $forum = $this->getDoctrine()->getRepository('ForumBundle:Sujet')->find($id);
        $comments = $em->getRepository('ForumBundle:Commentaire')->findBy([
            "idF"=>$id
        ]);
        //
        $ar = $em->getRepository(User::class)->find($forum->getIduser());
        $comment = new Commentaire();
        $form = $this->createFormBuilder($comment)
            ->add('descriptionCom',TextType::class,array('attr'=>array('class'=>'form-control') ))
            ->add('save',SubmitType::class,array('label'=>'Ajouter Comment','attr'=>array('class'=>'btn oneMusic-btn mt-30') ))
            ->getForm();
        $form->handleRequest($request);
        if($form->isSubmitted()&&$form->isValid()) {
            $desc=$form['descriptionCom']->getData();
            $comment->setDescriptionCom($desc);
            $comment->setDateCom(new \DateTime("now"));
            $comment->setIdUser($user);
            $comment->setIdF($forum->getIdF());
            // var_dump($comment);
            $em = $this->getDoctrine()->getManager();
            $em->persist($comment);
            $em->flush();
            $request->getSession()
                ->getFlashBag()
                ->add('success', 'Commentaire a été ajouté avec succées ...!');
            return $this->redirectToRoute('detail_sujet',array('id' => $id));
        }
        $em = $this->getDoctrine()->getManager();
        $ancien=$forum->getNbreJaime();
        $forum->setNbreJaime($ancien + 1 );
        $em->persist($forum);
        $em->flush();
        $repository= $em->getRepository(commentaire::class)->nombrecommentaires($forum->getIdF());

        return $this->render('@Forum/Forum/detailssujet.html.twig',array(
            'forum' => $forum,
            'comments'=>$comments,
            'user' => $user,
            'form'=>$form->createView(),
            'ar'=>$ar,
            'nbcom' =>$repository

        ));
    }


    public function likeAction(Request $request,$id)
    {
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        $em = $this->getDoctrine()->getManager();
        $forum = $this->getDoctrine()->getRepository('ForumBundle:Sujet')->find($id);
        $comments = $em->getRepository('ForumBundle:Commentaire')->findBy([
            "idF"=>$id
        ]);


        $comment = new Commentaire();
        $form = $this->createFormBuilder($comment)
            ->add('descriptionCom',TextType::class,array('attr'=>array('class'=>'form-control')))
            ->add('save',SubmitType::class,array('label'=>'Ajouter Comment','attr'=>array('class'=>'btn oneMusic-btn mt-30') ))
            ->getForm();
        $form->handleRequest($request);
        if($form->isSubmitted()&&$form->isValid()) {
            $desc=$form['descriptionCom']->getData();
            $comment->setDescriptionCom($desc);
            $comment->setDateCom(new \DateTime("now"));
            $comment->setIdUser($user);
            $comment->setIdF($forum->getIdF());
            // var_dump($comment);
            $em = $this->getDoctrine()->getManager();

            $em->persist($comment);
            $em->flush();

            $request->getSession()
                ->getFlashBag()
                ->add('success', 'Commentaire a été ajouté avec succées ...!');

            return $this->redirectToRoute('like',array('id' => $id));
        }
        $em = $this->getDoctrine()->getManager();
        $ancien=$forum->getNbreJaime();


        $forum->setNbreJaime($ancien + 1 );


        $em->persist($forum);
        $em->flush();

        //historique
        $name = $this->getUser()->getUsername();
        $historique=new historique ();
        $historique->setIdu($user);
        $historique->setDescription("User ".$name."liked a subject");
        $em->persist($historique);
        $em->flush();


        return $this->render('@Forum/Forum/detailssujet.html.twig',array(
            'forum' => $forum,
            'comments'=>$comments,
            'user' => $user,
            'form'=>$form->createView()
        ));
    }

    public function supprimerCommentAction($id,Request $request)
    {

        $user=$this->getUser();
        $com = $this->getDoctrine()->getRepository('ForumBundle:Commentaire')->find($id);
        //var_dump($com);

        $em =$this->getDoctrine()->getManager();
        $em->remove($com);
        $em->flush();

        //historique
        $name = $this->getUser()->getUsername();
        $historique=new historique ();
        $historique->setIdu($user);
        $historique->setDescription("User ".$name."deleted his comment");
        $em->persist($historique);
        $em->flush();

        return $this->redirectToRoute('detail_sujet',array('id' => $com->getIdF()));
    }

    public function modifierCommentAction(Request $request,$id)
    {
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        $em = $this->getDoctrine()->getManager();

        $com = $this->getDoctrine()->getRepository('ForumBundle:Commentaire')->find($id);
        $com->setDescriptionCom($com->getDescriptionCom());
        $forum = $this->getDoctrine()->getRepository('ForumBundle:Sujet')->find($com->getIdF());

        $form = $this->createFormBuilder($com)

            ->add('descriptionCom',TextType::class,array('attr'=>array('class'=>'form-control') ))

            ->add('save',SubmitType::class,array('label'=>'modifier Comment','attr'=>array('class'=>'btn btn-primary') ))
            ->getForm();
        $form->handleRequest($request);
        if($form->isSubmitted()&&$form->isValid()) {
            $desc=$form['descriptionCom']->getData();

            $com->setDescriptionCom($desc);
            $com->setDateCom($com->getDateCom());
            $com->setIdUser($user);
            $com->setIdF($com->getIdF());
            // var_dump($comment);
            $em = $this->getDoctrine()->getManager();
            $em->persist($com);
            $em->flush();

            //historique
            $name = $this->getUser()->getUsername();
            $historique=new historique ();
            $historique->setIdu($user);
            $historique->setDescription("User ".$name."modified his comment");
            $em->persist($historique);
            $em->flush();
            return $this->redirectToRoute('detail_sujet',array('id' => $com->getIdF()));
        }


        return $this->render('@Forum/Forum/modifierComment.html.twig',array(
            'form'=>$form->createView(),
            'forum' => $forum,
            'user' => $user,

        ));
    }

    public function articleAction($id)
    {

        $em = $this->getDoctrine()->getManager();
        $article = $em->getRepository(News::class)->find($id);
        $art = $em->getRepository(News::class)->findAll();
        $article->setnbrevue($article->getnbrevue()+1);
        $em->persist($article);
        $em->flush();


        $ar = $em->getRepository(User::class)->find($article->getIduser());
        $ar->getUsername();


        $queryBuilder = $em->getRepository('NewsBundle:News')->createQueryBuilder('bp');
        $queryBuilder->orderBy("bp.nbrevue", 'DESC');
        $event=$queryBuilder->getQuery();

        return $this->render("@News/News/article.html.twig",array('articles'=>$article,'ar'=>$ar,'events'=>$event,'art'=>$art));

    }

    public function chartAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        $forums = $em->getRepository('ForumBundle:Sujet')->findAll();
        $strikesup = $em->getRepository('ForumBundle:Sujet')->countstrikesup();
        $strikeinf = $em->getRepository('ForumBundle:Sujet')->countstrikeinf();

        dump($forums);
        dump($strikeinf);
        return $this->render('@Forum/Forum/chart.html.twig', array(
            'forums' => $forums,
            'user' => $user,
            'strikesup' => $strikesup,
            'strikeinf' => $strikeinf,

        ));
    }


    public function ajoutersujetAction(Request $request)
    {

        $sujet = new Sujet();
        $em = $this->getDoctrine()->getManager();
        $Form = $this->createForm(SujetType::class, $sujet);
        $Form->handleRequest($request);
        $b=date('d/m/Y');
        $tt=$em->getRepository(User::class)->findAll();
        $username = $this->getUser()->getUsername();

        if ($Form->isSubmitted() && $Form->isValid())/*verifier */ {
            $manager = $this->get('mgilet.notification');
            $notif = $manager->createNotification("Forum ajoutée le ".$b." par l'utulisateur ".$username);
            $notif->setMessage('');
            foreach ($tt as $value) {
                $manager->addNotification(array($value), $notif, true); }
            $sujet->setDate(new \DateTime("now"));
            $sujet->setNbreJaime(0);
            $user = $this->getUser();
            $sujet->setIdUser($user);
            $sujet->setStrike(0);
            $sujet->setEtat(0);
            /*on fait ça pour qu'on peut utiliser les fonction du entity manager l persist w flush*/
            $em->persist($sujet);
            $em->flush();

            //historique
            $name = $this->getUser()->getUsername();
            $historique=new historique ();
            $historique->setIdu($user);
            $historique->setDescription("User ".$name."added a new subject");
            $em->persist($historique);
            $em->flush();
            return $this->redirectToRoute('afficher_messujets');
        }

        return $this->render('@Forum/Forum/ajoutersujet.html.twig', array(
            'sujetform' => $Form->createView(),
              'faya3' => $tt
        ));
    }

    public function signalerAction($id,Request $request)
    {

        $user = $this->getUser();
        $signaler=new signaler();
        $em = $this->getDoctrine()->getManager();
        $sujet = $this->getDoctrine()->getRepository('ForumBundle:Sujet')->find($id);
        $Form = $this->createForm(signalerType::class, $signaler);
        $Form->handleRequest($request);
        if ($Form->isSubmitted() && $Form->isValid()){
            $signaler->setIdu($user);
            $signaler->setIdsujet($sujet);
            $ancien=$sujet->getStrike();
            $sujet->setStrike($ancien+1);
            $em->persist($signaler);
            $em->flush();
          //  dump($signaler);
            //historique
            $name = $this->getUser()->getUsername();
            $historique=new historique ();
            $historique->setIdu($user);
            $historique->setDescription("User".$name."signaled a subject");
            $em->persist($historique);
            $em->flush();
            return $this->redirectToRoute('detail_sujet',array('id' => $sujet->getIdF()));
        }
        return $this->render('@Forum/Forum/signalersujet.html.twig', array(
            'signalerform' => $Form->createView(),
        ));

    }

    public function signalerbackaction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $repository= $em->getRepository(sujet::class)->signaler();
        $nbsignale= $em->getRepository(sujet::class)->nbresujetsignale();
        $user = $this->getUser()->getUsername();


        return $this->render('@Forum/Forum/signalerback.html.twig', array(
            'sujetsignale' => $repository,
            'nbsignale' => $nbsignale

        ));


    }

    public function supprimersujetsignalerAction($id,Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        $sujet = $this->getDoctrine()->getRepository('ForumBundle:Sujet')->find($id);
        $emailuser=$sujet->getIdUser()->getEmail();
        $message = \Swift_Message::newInstance()
        ->setSubject('Forum')
        ->setFrom('mohamedamine.mbarki@esprit.tn')
        ->setTo($emailuser)
        ->setBody('Sujet supprimé car le nombre de strike a dépasser 99');
        $this->get('mailer')->send($message);
        $this->addFlash('info','Mail sent successfully');

        $em->remove($sujet);

        $em->flush();
        return $this->redirectToRoute('signalerback');


    }

    public function afficherhistoriqueAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        $historique = $em->getRepository("ForumBundle:historique")->findAll();
        return $this->render('@Forum/Forum/historiqueback.html.twig', array(
            'historique' => $historique,


        ));


    }

    public function deletehistoriqueAction (Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $repository= $em->getRepository(historique::class)->deletehistorique();
        return $this->redirectToRoute('historique');

    }


    /*Mobile*/

    public function toussujetsMAction()
    {
        $tasks=$this->getDoctrine()->getManager()->getRepository('ForumBundle:Sujet')->findAll();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted=$serializer->normalize($tasks);
        return new JsonResponse($formatted);
    }



}
