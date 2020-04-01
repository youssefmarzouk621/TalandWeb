<?php

namespace tvshowBundle\Controller;

use tvshowBundle\Entity\ratingtvshow;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Ratingtvshow controller.
 *
 * @Route("ratingtvshow")
 */
class ratingtvshowController extends Controller
{
    /**
     * Lists all ratingtvshow entities.
     *
     * @Route("/", name="ratingtvshow_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $ratingtvshows = $em->getRepository('tvshowBundle:ratingtvshow')->findAll();

        return $this->render('@tvshow/ratingtvshow/index.html.twig', array(
            'ratingtvshows' => $ratingtvshows,
        ));
    }

    /**
     * Creates a new ratingtvshow entity.
     *
     * @Route("/new", name="ratingtvshow_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $ratingtvshow = new Ratingtvshow();
        $form = $this->createForm('tvshowBundle\Form\ratingtvshowType', $ratingtvshow);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($ratingtvshow);
            $em->flush();

            return $this->redirectToRoute('ratingtvshow_show', array('id' => $ratingtvshow->getId()));
        }

        return $this->render('@tvshow/ratingtvshow/new.html.twig', array(
            'ratingtvshow' => $ratingtvshow,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a ratingtvshow entity.
     *
     * @Route("/{id}", name="ratingtvshow_show")
     * @Method("GET")
     */
    public function showAction(ratingtvshow $ratingtvshow)
    {
        $deleteForm = $this->createDeleteForm($ratingtvshow);

        return $this->render('@tvshow/ratingtvshow/show.html.twig', array(
            'ratingtvshow' => $ratingtvshow,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing ratingtvshow entity.
     *
     * @Route("/{id}/edit", name="ratingtvshow_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, ratingtvshow $ratingtvshow)
    {
        $deleteForm = $this->createDeleteForm($ratingtvshow);
        $editForm = $this->createForm('tvshowBundle\Form\ratingtvshowType', $ratingtvshow);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('ratingtvshow_edit', array('id' => $ratingtvshow->getId()));
        }

        return $this->render('@tvshow/ratingtvshow/edit.html.twig', array(
            'ratingtvshow' => $ratingtvshow,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a ratingtvshow entity.
     *
     * @Route("/{id}", name="ratingtvshow_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, ratingtvshow $ratingtvshow)
    {
        $form = $this->createDeleteForm($ratingtvshow);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($ratingtvshow);
            $em->flush();
        }

        return $this->redirectToRoute('ratingtvshow_index');
    }

    /**
     * Creates a form to delete a ratingtvshow entity.
     *
     * @param ratingtvshow $ratingtvshow The ratingtvshow entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(ratingtvshow $ratingtvshow)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('ratingtvshow_delete', array('id' => $ratingtvshow->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
