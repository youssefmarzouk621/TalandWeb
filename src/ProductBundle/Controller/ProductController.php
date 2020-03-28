<?php

namespace ProductBundle\Controller;


use ProductBundle\Entity\Produit;
use ProductBundle\Form\ProduitType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use UserBundle\Entity\User;

class ProductController extends Controller
{
    private $loggedInUser;

    /**
     * ProductController constructor.
     */
    public function __construct()
    {
        $this->loggedInUser = new User();

    }



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
            $Category = $form['category']->getData();
            $idCategory = $Category->getId();
            $product->setCategory($idCategory);
            $product->setPrice($form['price']->getData());
            $product->setDate(new \DateTime());
            if ($form['imgsrc']->getData() == 'NULL') {
                $product->setImgsrc('products.png');
            } else {
                $product->setImgsrc($form['imgsrc']->getData());
            }

            $em = $this->getDoctrine()->getManager();
            $em->persist($product);
            $em->flush();

            return $this->redirectToRoute('get_products');

        }
        return $this->render('@Product/Product/add_product.html.twig', array(
            'productForm' => $form->createView()));
    }

    public function deleteProductAction($id, Request $request)
    {
        if ($this->isCsrfTokenValid('delete' . $id, $request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $product = $em->getRepository(Produit::class)->find($id);
            $em->remove($product);
            $em->flush();
            return $this->redirectToRoute('get_products');
        }

        //  return $this->redirectToRoute('delete_product');


    }
}
