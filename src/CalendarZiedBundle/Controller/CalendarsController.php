<?php

namespace CalendarZiedBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use CalendarZiedBundle\Entity\Calendars;
use CalendarZiedBundle\Entity\deals;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Calendar controller.
 *
 * @Route("calendars")
 */
class CalendarsController extends Controller
{
    /**
     * Lists all calendar entities.
     *
     * @Route("/", name="calendars_index")
     * @Method("GET")
     */



    public function indexAction()
    {
        $user=$this->getUser();
        $em = $this->getDoctrine()->getManager();
        $calendars = $em->getRepository('CalendarZiedBundle:Calendars')->Findbyuser($user->getId());
        return $this->render('@CalendarZied/calendars/index.html.twig', array(
            'calendars' => $calendars,
        ));
    }

    /**
     * Lists all calendar entities.
     *
     * @Route("/showall", name="calendars_showall")
     * @Method("GET")
     */
    public function ShowAllAction()
    {
        $em = $this->getDoctrine()->getManager();


        $calendars = $em->getRepository('CalendarZiedBundle:Calendars')->findAll();

        return $this->render('@CalendarZied/calendars/allcalendars.html.twig', array(
            'calendars' => $calendars,
        ));
    }



    /**
     * Creates a new calendar entity.
     *
     * @Route("/new", name="calendars_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $calendar = new Calendars();
        $form = $this->createForm('CalendarZiedBundle\Form\CalendarsType', $calendar);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($calendar);
            $em->flush();

            return $this->redirectToRoute('calendars_show', array('calendarname' => $calendar->getCalendarname()));
        }

        return $this->render('@CalendarZied/calendars/new.html.twig', array(
            'calendar' => $calendar,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a calendar entity.
     *
     * @Route("/{calendarname}", name="calendars_show")
     * @Method("GET")
     */

    public function showAction(Calendars $calendar)
{
    $deleteForm = $this->createDeleteForm($calendar);
    $deals=$this->getDoctrine()->getManager()->getRepository(deals::class)->Findbycalendarname($calendar->getCalendarname());

    return $this->render('@CalendarZied/calendars/show.html.twig', array(
        'calendar' => $calendar,'deals'=>$deals,
        'delete_form' => $deleteForm->createView(),
    ));
}




    /**
     * Displays a form to edit an existing calendar entity.
     *
     * @Route("/{calendarname}/edit", name="calendars_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Calendars $calendar)
    {
        $deleteForm = $this->createDeleteForm($calendar);
        $editForm = $this->createForm('CalendarZiedBundle\Form\CalendarsType', $calendar);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('calendars_index', array('calendarname' => $calendar->getCalendarname()));
        }

        return $this->render('@CalendarZied/calendars/edit.html.twig', array(
            'calendar' => $calendar,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a calendar entity.
     *
     * @Route("/{calendarname}", name="calendars_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Calendars $calendar)
    {

        $form = $this->createDeleteForm($calendar);
        $form->handleRequest($request);


        $em = $this->getDoctrine()->getManager();
        $em->remove($calendar);
        $em->flush();


        return $this->redirectToRoute('calendars_index');
    }





    /**
     * Creates a form to delete a calendar entity.
     *
     * @param Calendars $calendar The calendar entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Calendars $calendar)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('calendars_delete', array('calendarname' => $calendar->getCalendarname())))
            ->setMethod('DELETE')
            ->getForm()
            ;
    }



}
