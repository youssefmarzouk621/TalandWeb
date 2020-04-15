<?php

namespace tvshowBundle\Controller;

use tvshowBundle\Entity\commentairetvshow;
use tvshowBundle\Entity\reclamationtvshow;
use tvshowBundle\Entity\Tvshow;
use tvshowBundle\Entity\ratingtvshow;
use Symfony\Component\HttpFoundation\File\File;
use tvshowBundle\Repository\ratingtvshowRepository;
use tvshowBundle\Repository\commentairetvshowRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;
use tvshowBundle\Repository\TvshowRepository;

/**
 * Tvshow controller.
 *
 * @Route("tvshow")
 */
class TvshowController extends Controller
{
    /**
     * Lists all tvshow entities.
     *
     * @Route("/", name="tvshow_index")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $tvshows = $em->createQueryBuilder();
        $recenttvshows = $em->createQueryBuilder();
        $topviews = $em->createQueryBuilder();
        $tvshows->select('t')
            ->from(Tvshow::class, 't')

            ->groupBy('t.name')
        ;

        $topviews->select('t')
            ->from(Tvshow::class, 't')
            ->where('t.nbrvues > 10' )
            ->groupBy('t.name')
            ->setMaxResults(5)
        ;

        $recenttvshows->select('t')
            ->from(Tvshow::class, 't')
            ->where('t.year = 2020' )
            ->groupBy('t.name')
            ->setMaxResults(5)
        ;

        $dat = $tvshows->getQuery()->getResult();
       $data  = $this->get('knp_paginator')->paginate(
            $dat,
            $request->query->get('page', 1),
      7
        );
        $data2 = $recenttvshows->getQuery()->getResult();
        $data3 = $topviews->getQuery()->getResult();
        return $this->render('@tvshow/tvshow/index.html.twig', array(
            'tvshows' => $data,'tvshowrecent' => $data2,'topviews' => $data3
        ));
    }

    /**
     * Creates a new tvshow entity.
     *
     * @Route("/new", name="tvshow_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $tvshow = new Tvshow();
        $form = $this->createForm('tvshowBundle\Form\TvshowType', $tvshow);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $tvshow->uploadProfilePicture();
            $tvshow->uploadgaleriepicture1();
            $tvshow->uploadgaleriepicture2();
            $tvshow->uploadgaleriepicture3();
            $tvshow->uploadgaleriepicture4();
            $tvshow->uploadgaleriepicture5();
            $tvshow->setNbrvues(0);
            $em = $this->getDoctrine()->getManager();
            $em->persist($tvshow);
            $em->flush();
            return $this->redirectToRoute('adminshows', array('id' => $tvshow->getId()));
        }

        return $this->render('@tvshow/tvshow/new.html.twig', array(
            'tvshow' => $tvshow,
            'form' => $form->createView(),
        ));

    }


    /**
     * Lists all tvshow entities.
     *
     * @Route("/tvshow_report/{id}", name="tvshow_report")
     * @Method({"GET"})
     */

   public function reportAction(Request $request,$id){

       $em = $this->getDoctrine()->getManager();
       $tvshows = $em->createQueryBuilder();
       $tvshows->select('t')
           ->from(Tvshow::class, 't')

           ->groupBy('t.name')
       ;
       $dat = $tvshows->getQuery()->getResult();
       $tvshow= $em->getRepository('tvshowBundle:Tvshow')->findOneBy(array('id'=>$id));
       $reclamationtvshow = new Reclamationtvshow();
       $form = $this->createForm('tvshowBundle\Form\reclamationtvshowType',$reclamationtvshow);
       $form->handleRequest($request);
       $reclamationtvshow->setTvshow($tvshow);
       if ($form->isSubmitted() && $form->isValid()) {
           $user = $this->container->get('security.token_storage')->getToken()->getUser();
           if($user != 'anon.')
           { $reclamationtvshow->setIdu($user);

              }
           $em = $this->getDoctrine()->getManager();
           $em->persist($reclamationtvshow);
           $em->flush();

           return $this->redirectToRoute('reclamationtvshow_new', array('id' => $reclamationtvshow->getId()));
       }
       $dat = $tvshows->getQuery()->getResult();
       $data  = $this->get('knp_paginator')->paginate(
           $dat,
           $request->query->get('page', 1),
           5
       );

       return $this->render('@tvshow/reclamationtvshow/new.html.twig', array(
           'reclamationtvshow' => $reclamationtvshow,
           'form' => $form->createView(),

       ));
    }
    /**
     * Finds and displays a tvshow entity.
     * @Route("/{id}", name="tvshow_show")
     * @Method("GET")
     */
    public function showAction(Tvshow $tvshow , Request $request)
    {    $em = $this->getDoctrine()->getManager();
        $commentairetadd = new Commentairetvshow();
        $ratingadd = new ratingtvshow();
            $current = $this->get('security.token_storage')->getToken()->getUser();
      $tvshow->setNbrvues($tvshow->getNbvues()+1);
        $this->getDoctrine()->getManager()->flush();
        $ratingg=$em->getRepository(ratingtvshow::class)->nombrerating($tvshow->getId());
        $nbrcomm=$em->getRepository(commentairetvshow::class)->nombrecommentaires($tvshow->getId());
        $somme=$em->getRepository(ratingtvshow::class)->sommerating($tvshow->getId());
        $somme1=$em->getRepository(ratingtvshow::class)->nombrerating1($tvshow->getId());
        $somme2=$em->getRepository(ratingtvshow::class)->nombrerating2($tvshow->getId());
        $somme3=$em->getRepository(ratingtvshow::class)->nombrerating3($tvshow->getId());
        $somme4=$em->getRepository(ratingtvshow::class)->nombrerating4($tvshow->getId());
        $somme5=$em->getRepository(ratingtvshow::class)->nombrerating5($tvshow->getId());
        $formrating = $this->createForm('tvshowBundle\Form\ratingtvshowType', $ratingadd);
        $formrating->handleRequest($request);

        $editForm = $this->createForm('tvshowBundle\Form\ratingtvshowType', $ratingadd);

        if($current != 'anon.') {
            $existerating = $em->getRepository(ratingtvshow::class)->existerating($tvshow->getId(), $current->getId());
        }
        else{
            $existerating=100;
        }
        if($current != 'anon.') {
     if($existerating ==0){

         if ($formrating->isSubmitted() && $formrating->isValid()) {
             $user = $this->container->get('security.token_storage')->getToken()->getUser();
             if($user != 'anon.')
             {  $ratingadd->setUserId($user);}
             $ratingadd->setTvshow($tvshow);
             $em->persist( $ratingadd);
             $em->flush();
             return  $this->redirectToRoute('tvshow_show', array('id' => $tvshow->getId()));


         }
     }
        if($existerating != 0){

            $rating=$em->getRepository(ratingtvshow::class)->findOneBy((array('User_id' =>  $current->getId() ,'tvshow' =>  $tvshow )));
            if ($editForm->isSubmitted() && $editForm->isValid()) {
                $this->getDoctrine()->getManager()->refresh($rating)->flush();

                return $this->redirectToRoute('tvshow_show', array('id' => $tvshow->getId()));
            }
            $editForm->handleRequest($request);
        }

        }
        $form = $this->createForm('tvshowBundle\Form\commentairetvshowType', $commentairetadd);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->container->get('security.token_storage')->getToken()->getUser();
            if($user != 'anon.')
            {  $commentairetadd->setUserId($user);}
            $commentairetadd->setTvshow($tvshow);
            $em->persist( $commentairetadd);
            $em->flush();
         return  $this->redirectToRoute('tvshow_show', array('id' => $tvshow->getId()));


        }


        $commentairetvshows = $em->getRepository('tvshowBundle:commentairetvshow')->findBy((array('tvshow' =>  $tvshow )));
        $deleteForm = $this->createDeleteForm($tvshow);
        $tvshows = $em->getRepository('tvshowBundle:Tvshow')->findBy((array('name' =>  $tvshow->getName() )));
        $size = count($tvshows);
        return $this->render('@tvshow/tvshow/show.html.twig' , array(
            'tvshow' => $tvshow,'tvshows' => $tvshows,'commentairetvshow' => $commentairetvshows,'rated' => $existerating,'nbrcomm' => $nbrcomm ,'nombre' => $ratingg,'somm2' => $somme2,'somm3' => $somme3,'somm4' => $somme4,'somm5' => $somme5,'somm' => $somme,'somm1' => $somme1, 'size' => $size,'user' => $current,'formrating' => $formrating->createView(), 'formeditrating' => $editForm->createView(),'formajout' => $form->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing tvshow entity.
     *
     * @Route("/{id}/modifiertvshow", name="modifiertvshow")
     * @Method({"GET", "POST"})
     */
    public function modifiertvshowAction(Request $request, Tvshow $tvshow)
    {
        $deleteForm = $this->createDeleteForm($tvshow);
        $editForm = $this->createForm('tvshowBundle\Form\TvshowType', $tvshow);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('modifiertvshow', array('id' => $tvshow->getId()));
        }

        return $this->render('@tvshow/tvshow/edit.html.twig', array(
            'tvshow' => $tvshow,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a tvshow entity.
     *
     * @Route("/{id}", name="tvshow_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Tvshow $tvshow)
    {
        $id = $tvshow->getId();
        $em = $this->getDoctrine()->getManager();
        $em->remove($tvshow);
        $em->flush();

        return $this->redirectToRoute('tvshow_index');
    }


    public function supprimerTvshowAction($id)
    {

        $em = $this->getDoctrine()->getManager();
        $tvshow= $em->getRepository('tvshowBundle:Tvshow')->findOneBy(array('id'=>$id));
        $em->remove($tvshow);
        $em->flush();
        return $this->redirectToRoute('adminshows');
    }

    /**
     * Creates a form to delete a tvshow entity.
     *
     * @param Tvshow $tvshow The tvshow entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Tvshow $tvshow)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('tvshow_delete', array('id' => $tvshow->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * displays a tvshow entity.
     * @Route("/affichetvshowadmin/", name="adminshows")
     * @Method("GET")
     */

    public function affichagetvshowadminAction()
    {   $em = $this->getDoctrine()->getManager();

        $nomb = $em->createQueryBuilder();
        $nombre =
        $nomb->select('count(t)')
            ->from(Tvshow::class, 't')
            ->getQuery()

            ->getSingleScalarResult();


        $tvshows = $em->getRepository('tvshowBundle:Tvshow')->findAll();
        return $this->render('@tvshow/tvshow/showadmin.html.twig',array('tvshows'=>$tvshows,'nombre'=>$nombre));
    }
}
