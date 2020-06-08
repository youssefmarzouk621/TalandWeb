<?php

namespace tvshowBundle\Controller;

use PostsBundle\Entity\Posts;
use Symfony\Component\HttpFoundation\JsonResponse;
use tvshowBundle\Entity\commentairetvshow;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Commentairetvshow controller.
 *
 * @Route("commentairetvshow")
 */
class commentairetvshowController extends Controller
{
    /**
     * Lists all commentairetvshow entities.
     *
     * @Route("/", name="commentairetvshow_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $commentairetvshows = $em->getRepository('tvshowBundle:commentairetvshow')->findAll();

        return $this->render('@tvshow/commentairetvshow/index.html.twig', array(
            'commentairetvshows' => $commentairetvshows,
        ));
    }

    /**
     * Creates a new commentairetvshow entity.
     *
     * @Route("/new", name="commentairetvshow_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $commentairetvshow = new Commentairetvshow();
        $form = $this->createForm('tvshowBundle\Form\commentairetvshowType', $commentairetvshow);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->container->get('security.token_storage')->getToken()->getUser();
            if($user != 'anon.')
            { $commentairetvshow->setUserId($user);}
            $em = $this->getDoctrine()->getManager();
            $em->persist($commentairetvshow);
            $em->flush();

            return $this->redirectToRoute('commentairetvshow_show', array('id' => $commentairetvshow->getId()));
        }

        return $this->render('@tvshow/commentairetvshow/new.html.twig', array(
            'commentairetvshow' => $commentairetvshow,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a commentairetvshow entity.
     *
     * @Route("/{id}", name="commentairetvshow_show")
     * @Method("GET")
     */
    public function showAction(commentairetvshow $commentairetvshow)
    {
        $deleteForm = $this->createDeleteForm($commentairetvshow);

        return $this->render('@tvshow/commentairetvshow/show.html.twig', array(
            'commentairetvshow' => $commentairetvshow,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing commentairetvshow entity.
     *
     * @Route("/{id}/edit", name="commentairetvshow_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, commentairetvshow $commentairetvshow)
    {
        $deleteForm = $this->createDeleteForm($commentairetvshow);
        $editForm = $this->createForm('tvshowBundle\Form\commentairetvshowType', $commentairetvshow);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('commentairetvshow_edit', array('id' => $commentairetvshow->getId()));
        }

        return $this->render('@tvshow/commentairetvshow/edit.html.twig', array(
            'commentairetvshow' => $commentairetvshow,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a commentairetvshow entity.
     *
     * @Route("/{id}", name="commentairetvshow_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, commentairetvshow $commentairetvshow)
    {
        $form = $this->createDeleteForm($commentairetvshow);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($commentairetvshow);
            $em->flush();
        }

        return $this->redirectToRoute('commentairetvshow_index');
    }

    /**
     * Creates a form to delete a commentairetvshow entity.
     *
     * @param commentairetvshow $commentairetvshow The commentairetvshow entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(commentairetvshow $commentairetvshow)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('commentairetvshow_delete', array('id' => $commentairetvshow->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    public function supprimercommentTvshowAction($id)
{
    $em = $this->getDoctrine()->getManager();
    $com=$em->getRepository(commentairetvshow::class)->find($id);
    //var_dump($com);
    $em->remove($com);
    $em->flush();

    return new JsonResponse("del");
    /*$em = $this->getDoctrine()->getManager();
    $commentaire= $em->getRepository('tvshowBundle:commentairetvshow')->findOneBy(array('id'=>$id));

    $em->remove($commentaire);
    $em->flush();*/
    //return $this->redirectToRoute('tvshow_show', array('id' => $tvshow->getId()));
}

    public function supcomchekibAction($id){
        var_dump($id);
        return new JsonResponse("del");
    }
}