<?php

namespace ProductBundle\Controller;

use ProductBundle\Entity\Basket;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use UserBundle\Entity\User;

class CartController extends Controller
{

    public function getCartsAction(){
        $carts=new Basket();
        $em=$this->getDoctrine()->getManager();
        $carts=$em->getRepository('ProductBundle:Basket')->findAll();
        $user=new User();
        $emUser=$this->getDoctrine()->getManager()->getRepository('UserBundle:User');

        foreach ($carts as $cart){
            $user=$emUser->find($cart->getUserid());

        }
        return $this->render('@Product/Admin/get_cart.html.twig',array('carts'=>$carts));

    }
}
