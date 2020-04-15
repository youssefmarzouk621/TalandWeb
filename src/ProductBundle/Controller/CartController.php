<?php

namespace ProductBundle\Controller;

use Knp\Bundle\SnappyBundle\Snappy\Response\PdfResponse;
use ProductBundle\Entity\Basket;
use ProductBundle\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use UserBundle\Entity\User;

class CartController extends Controller
{
    public function indexAction(SessionInterface $session)
    {
        $cart = $session->get('cart', []);
        $cartWithData = [];
        foreach ($cart as $id => $quantity) {
            $cartWithData[] = [
                'product' => $this->getDoctrine()->getRepository('ProductBundle:Produit')->find($id),
                'quantity' => $quantity
            ];
        }
        $total = 0;
        foreach ($cartWithData as $item) {
            $total += $item['product']->getPrice();
        }
        return $this->render('@Product/Cart/cart_index.html.twig', ['items' => $cartWithData, 'total' => $total, 'nbrProduct' => sizeof($cart)]);
    }

    public function getCartsAction(SessionInterface $session)
    {
        $carts = new Basket();
        $cart = $session->get('cart', []);
        $em = $this->getDoctrine()->getManager();
        $carts = $em->getRepository('ProductBundle:Basket')->findAll();
        return $this->render('@Product/Admin/get_cart.html.twig', array('carts' => $carts));
    }

    public function addAction($id, SessionInterface $session)
    {

        $cart = $session->get('cart', []);
        $cart[$id] = 1;
        $session->set('cart', $cart);


        $this->addFlash("success", "projet creer avec succee");
        return $this->json(['code' => 200, 'message' => 'sa marche bien', 'nbrProduct' => sizeof($cart)], 200);


    }

    public function removeAction($id, SessionInterface $session)
    {
        $cart = $session->get('cart', []);
        if (!empty($cart[$id])) {
            unset($cart[$id]);
        }
        $session->set('cart', $cart);
        return $this->redirectToRoute('cart_index');
    }


    public function validateAction(SessionInterface $session){
        $user = $this->getUser();
        $cart = $session->get('cart', []);
        $cartWithData = [];
        foreach ($cart as $id => $quantity) {
            $cartWithData[] = [
                'product' => $this->getDoctrine()->getRepository('ProductBundle:Produit')->find($id),
                'quantity' => $quantity
            ];
        }
        $total = 0;
        foreach ($cartWithData as $item) {
            $total += $item['product']->getPrice();



            $message=(new \Swift_Message('Hello Email'))
                ->setFrom('talandpidev@gmail.com')
                ->setTo('hamza.benguirat@esprit.tn')
                ->setBody(
                    $this->renderView('@Product/Cart/cart_mail.html.twig',
                        ['nameReciever'=>$item['product']->getUserid()->getFirstname(),
                            'nameSender'=>$user->getFirstname(),
                            'emailSender'=>$user->getEmail(),
                            'productName'=>$item['product']->getName()]
                    ),
                    'text/html');
            $this->get('mailer')->send($message);
            //$mailer->send($message);

        }
        $snappy=$this->get("knp_snappy.pdf");



        $fileName="My Cart";






        $session->remove('cart');
        return new Response(
            $snappy->getOutputFromHtml($this->renderView("@Product/Cart/cart_facture.html.twig", array(
                'items' => $cartWithData, 'total' => $total

            ))),
            200,
            array(
                'Content-Type'=> 'application/pdf',
                'Content-Disposition' =>'inline; filename="'.$fileName.'.pdf"'
            )
        );



    }
}
