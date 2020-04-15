<?php

namespace tvshowBundle\Controller;

use tvshowBundle\Entity\ratingtvshow;
use tvshowBundle\Entity\reclamationtvshow;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Reclamationtvshow controller.
 *
 * @Route("reclamationtvshow")
 */
class reclamationtvshowController extends Controller
{
    /**
     * Lists all reclamationtvshow entities.
     *
     * @Route("/", name="reclamationtvshow_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
      //
        $reclamationtvshows = $em->getRepository('tvshowBundle:reclamationtvshow')->findAll();

        return $this->render('@tvshow/reclamationtvshow/showreportadmin.html.twig', array(
            'reclamationtvshows' => $reclamationtvshows,/*'tri' => $tri*/

        ));
    }
    /**
     * Lists all reclamationtvshow entities.
     *
     * @Route("/recherche", name="recherche")
     * @Method("GET")
     */
    public function rechercheAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        //  $tri=$em->getRepository(reclamationtvshow::class)->recherche();
        $nomCat=$request->get('motcle');
        $recherche=$em->getRepository(reclamationtvshow::class)->recherche(  $nomCat);

        return $this->render('@tvshow/reclamationtvshow/showreportadmin.html.twig', array(
            'reclamationtvshows' => $recherche,/*'tri' => $tri*/

        ));
    }

    /**
     * Creates a new reclamationtvshow entity.
     *
     * @Route("/new", name="reclamationtvshow_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $reclamationtvshow = new Reclamationtvshow();
        $form = $this->createForm('tvshowBundle\Form\reclamationtvshowType', $reclamationtvshow);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->container->get('security.token_storage')->getToken()->getUser();
            if($user != 'anon.')
            { $reclamationtvshow->setIdu($user);}
            $em = $this->getDoctrine()->getManager();
            $em->persist($reclamationtvshow);
            $em->flush();

            return $this->redirectToRoute('tvshow_index', array('id' => $reclamationtvshow->getId()));
        }

        return $this->render('@tvshow/reclamationtvshow/new.html.twig', array(
            'reclamationtvshow' => $reclamationtvshow,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a reclamationtvshow entity.
     *
     * @Route("/{id}", name="reclamationtvshow_show")
     * @Method("GET")
     */
    public function showAction(reclamationtvshow $reclamationtvshow)
    {
        $deleteForm = $this->createDeleteForm($reclamationtvshow);

        return $this->render('@tvshow/reclamationtvshow/show.html.twig', array(
            'reclamationtvshow' => $reclamationtvshow,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing reclamationtvshow entity.
     *
     * @Route("/{id}/reclamationtvshow_edit", name="reclamationtvshow_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, reclamationtvshow $reclamationtvshow)
    {
        if($reclamationtvshow->getResponsetype()=="sms"){

            $twilio = $this->get('twilio.api');

            $message = $twilio->account->messages->sendMessage(
                '+12055284180', // From a Twilio number in your account
                '+21652847468', // Text any number
                "You Report Has Been Confirmed"
            );

            //get an instance of \Service_Twilio
            $otherInstance = $twilio->createInstance('BBBB', 'CCCCC');

            print $message->sid;

        }


else{
            $message = \Swift_Message::newInstance()
                ->setSubject('Report')
                ->setFrom('mohamedchakib.hajji@esprit.tn')
                ->setTo($reclamationtvshow->getIdu()->getEmail())
                ->setBody('Votre Réclamation A été prise en considération nous avons supprimé le contenu ');
            $this->get('mailer')->send($message);
        $this->addFlash('info','Mail sent successfully');
}
        $reclamationtvshow->setEtat('1');
        $this->getDoctrine()->getManager()->flush();
        $em = $this->getDoctrine()->getManager();
        $reclamationtvshows = $em->getRepository('tvshowBundle:reclamationtvshow')->findAll();

        return $this->render('@tvshow/reclamationtvshow/showreportadmin.html.twig', array(
            'reclamationtvshows' => $reclamationtvshows,
        ));
    }

    /**
     * Deletes a reclamationtvshow entity.
     *
     * @Route("/{id}", name="reclamationtvshow_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, reclamationtvshow $reclamationtvshow)
    {
        $form = $this->createDeleteForm($reclamationtvshow);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($reclamationtvshow);
            $em->flush();
        }

        return $this->redirectToRoute('reclamationtvshow_index');
    }

    /**
     * Creates a form to delete a reclamationtvshow entity.
     *
     * @param reclamationtvshow $reclamationtvshow The reclamationtvshow entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(reclamationtvshow $reclamationtvshow)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('reclamationtvshow_delete', array('id' => $reclamationtvshow->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
