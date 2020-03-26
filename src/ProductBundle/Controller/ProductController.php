<?php

namespace ProductBundle\Controller;


use ProductBundle\Entity\Produit;
use ProductBundle\Form\ProduitType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ProductController extends Controller
{
    public function getProductsAction()
    {
        $product = new Produit();

        $em = $this->getDoctrine()->getManager();
        $product = $em->getRepository('ProductBundle:Produit')->findAll();
        return $this->render('@Product/Product/get_products.html.twig', array('Produit' => $product));
    }

    public function getProductByIdAction($id)
    {
        $product = new Produit();
        $em = $this->getDoctrine()->getManager();
        $product = $em->getRepository('ProductBundle:Produit')->find($id);
        return $this->render('@Product/Product/product_details.html.twig', array('product' => $product));

    }

    public function addProductAction(Request $request)
    {
        $product = new Produit();
        $product->setDate(new \DateTime());
        $product->setUserid(1);
        $product->setValidation(0);
        $form = $this->createForm(ProduitType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $product->setName($form['name']->getData());
            $product->setCategory($form['category']->getData());
            $product->setPrice($form['price']->getData());
            $product->setDate($form['date']->getData());
            $product->setImgsrc($form['imgsrc']->getData());
            $em = $this->getDoctrine()->getManager();
            $em->persist($product);
            $em->flush();

            return $this->redirectToRoute('get_products');

        }
        return $this->render('@Product/Product/add_product.html.twig', array(
            'productForm' => $form->createView()));
    }

    public function deleteProductAction($id,$validation){
        if ($validation=="yes"){
            $em=$this->getDoctrine()->getManager();
            $product=$em->getRepository(Produit::class)->find($id);
            $em->remove($product);
            $em->flush();

        }

        return $this->render('@Product/Product/delete_product.html.twig',array('id'=>$id));
      //  return $this->redirectToRoute('delete_product');


    }
}
