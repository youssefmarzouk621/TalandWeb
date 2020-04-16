<?php

namespace CalendarZiedBundle\Controller;

use CalendarZiedBundle\Entity\deals;
use CalendarZiedBundle\Entity\Message;
use CalendarZiedBundle\Form\MessageType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Deal controller.
 *
 * @Route("deals")
 */
class dealsController extends Controller
{
    /**
     * Lists all deal entities.
     *
     * @Route("/", name="deals_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $user=$this->getUser();
        $em = $this->getDoctrine()->getManager();
        $current = $this->get('security.token_storage')->getToken()->getUser()->getId();
        $m = $em->getRepository('CalendarZiedBundle:Message')->messagenotseen2($current);
        $deals = $em->getRepository('CalendarZiedBundle:deals')->Finddealsbyuser($user->getId());

        return $this->render('@CalendarZied/deals/index.html.twig', array(
            'deals' => $deals,
            'm' => $m,
        ));
    }

    /**
     * Creates a new deal entity.
     *
     * @Route("/new", name="deals_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $deal = new Deals();
        $form = $this->createForm('CalendarZiedBundle\Form\dealsType', $deal);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($deal);
            $em->flush();

            return $this->redirectToRoute('calendars_index', array('eventdescription' => $deal->getEventdescription()));
        }

        return $this->render('@CalendarZied/deals/new.html.twig', array(
            'deal' => $deal,
            'form' => $form->createView(),
        ));
    }

    public function resizeEventAction(Request $request)
    {
        if ($request->isXmlHttpRequest())
        {
            $idEvent = $request->request->get('eventdescription');
            $startDate = $request->request->get('start');
            $endDate = $request->request->get('end');

            $em = $this->getDoctrine()->getManager();
            $rst = $em->getRepository(deals::class)->resizeEvent($idEvent,$startDate,$endDate);

        }

        return new Response("Erreur.");
    }

    public function dropEventAction(Request $request)
    {
        if ($request->isXmlHttpRequest())
        {
            $idEvent = $request->request->get('eventdescription');
            $startDate = $request->request->get('start');
            $endDate = $request->request->get('end');

            $em = $this->getDoctrine()->getManager();
            $rst = $em->getRepository(deals::class)->dropEvent($idEvent,$startDate,$endDate);

        }
        return new Response("Erreur.");
    }

    public function deleteEventAction(Request $request)
    {
        if ($request->isXmlHttpRequest())
        {
            $idEvent = $request->request->get('eventdescription');

            $em = $this->getDoctrine()->getManager();
            $rst = $em->getRepository(deals::class)->deleteEvent($idEvent);

        }

        return new Response("Erreur.");
    }

    /**
     * Finds and displays a deal entity.
     *
     * @Route("/{eventdescription}", name="deals_show")
     * @Method("GET")
     */
    public function showAction(deals $deal)
    {
        $deleteForm = $this->createDeleteForm($deal);

        return $this->render('@CalendarZied/deals/show.html.twig', array(
            'deal' => $deal,
            'delete_form' => $deleteForm->createView(),
        ));
    }



    /**
     * Finds and displays a deal entity.
     *
     * @Route("/negotiate/{eventdescription}", name="deals_negotiate")
     * @Method("GET")
     */
    public function negotiateAction(Request $request,deals $deal)
    {
        $idu= $deal->getIdu();

        $current = $this->get('security.token_storage')->getToken()->getUser()->getId();
        $em = $this->getDoctrine()->getManager();
        $message = $em->getRepository('CalendarZiedBundle:Message')->findmessage($deal->getEventdescription());
        $m = $em->getRepository('CalendarZiedBundle:Message')->messagenotseen($current);
        $addmsg= new Message();
        $Form=$this->createForm(MessageType::class,$addmsg);
        $Form->handleRequest($request);

        if ($Form->isSubmitted()&&$Form->isValid())
        {
            $addmsg->setDateenvoi(new \DateTime());
            $addmsg->setIdu($this->getUser());
            $addmsg->setEventdescription($deal->getEventdescription());
            $addmsg->setIdreceiver($deal->getIdu()->getId());
            $addmsg->setSeen(1);
            $em->persist($addmsg);
            $em->flush();
            return $this->redirectToRoute('deals_negotiate', array('eventdescription' => $deal->getEventdescription()));

        }
        return $this->render('@CalendarZied/deals/negotiate.html.twig', array(
            'deal' => $deal,
            'message' => $message,
            'm' => $m,
            'user' => $current,
            'idu' => $idu,
            'msgform'=>$Form->createView()
        ));
    }


    /**
     * Displays a form to edit an existing deal entity.
     *
     * @Route("/{eventdescription}/edit", name="deals_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, deals $deal)
    {
        $deleteForm = $this->createDeleteForm($deal);
        $editForm = $this->createForm('CalendarZiedBundle\Form\dealsType', $deal);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('deals_edit', array('eventdescription' => $deal->getEventdescription()));
        }

        return $this->render('@CalendarZied/deals/edit.html.twig', array(
            'deal' => $deal,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a deal entity.
     *
     * @Route("/{eventdescription}", name="deals_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, deals $deal)
    {
        $form = $this->createDeleteForm($deal);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($deal);
            $em->flush();
        }

        return $this->redirectToRoute('deals_index');
    }

    /**
     * Creates a form to delete a deal entity.
     *
     * @param deals $deal The deal entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(deals $deal)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('deals_delete', array('eventdescription' => $deal->getEventdescription())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
