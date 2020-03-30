<?php

namespace ProductBundle\Controller;

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
}
