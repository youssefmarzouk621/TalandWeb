<?php

namespace ProductBundle\Controller;


use ProductBundle\Entity\Category;
use ProductBundle\Entity\Produit;
use ProductBundle\Form\ProduitType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
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


    public function getProductsAction(SessionInterface $session)
    {
        $user = $this->getUser();
        $cart = $session->get('cart', []);
        $user=$this->getUser();
        $product = new Produit();

        $em = $this->getDoctrine()->getManager();
//        $product = $em->getRepository('ProductBundle:Produit')->findAll();
        $product = $em->getRepository(Produit::class)->loadMoreProducts(18, 0);
        if ($user) {
            if ($user->hasRole('ROLE_ADMIN'))
                return $this->render('@Product/Admin/admin_products.html.twig', array('Produit' => $product));
        }

        return $this->render('@Product/Product/get_products.html.twig', array('Produit' => $product, 'nbrProduct' => sizeof($cart)));

    }

    public function updateProductAction(Request $request,$id){
        $product=$this->getDoctrine()->getManager()->getRepository('ProductBundle:Produit')->find($id);
        $form = $this->createForm(ProduitType::class, $product);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $product->setName($form['name']->getData());
            $Category = $form['category']->getData();
            $product->setCategory($Category);
            $product->setPrice($form['price']->getData());
            $product->setDate(new \DateTime());
            if ( is_null($form['imgsrc']->getData()) ) {
            } else {
                try {$file = $request->files->get('productbundle_produit')['imgsrc'];
                    $uploads_directory = $this->getParameter('uploads_directory');
                    $fileName = $file->getClientOriginalName();
                    $file->move($uploads_directory, $fileName);
                    $product->setName($form['name']->getData());
                    $product->setImgsrc($fileName);
                }catch (\Exception $e){
                }
            }
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            $this->addFlash('successUpdate', 'Product updated.');
            return $this->redirectToRoute('get_product_by_id',['id'=>$id]);
        }
        return $this->render('@Product/Product/update_product.html.twig', array(
            'productFormUpdate' => $form->createView()));
    }

    public function loadMoreProductsAction($start, $limit)
    {
        $product = new Produit();
        $em = $this->getDoctrine()->getManager();
//        $product = $em->getRepository('ProductBundle:Produit')->findAll();
        $product = $em->getRepository(Produit::class)->loadMoreProducts($limit, $start);
        $products = array();
        foreach ($product as $key => $p) {
            $products[$key]['id'] = $p->getId();
            $products[$key]['name'] = $p->getName();
            $products[$key]['price'] = $p->getPrice();
            $products[$key]['imgsrc'] = $p->getImgsrc();
            $products[$key]['userId'] = $this->getEntityUserJson($p);
            $products[$key]['date'] = $p->getDate();
            $products[$key]['category'] = $p->getCategory();
        }
        return new JsonResponse($products);
    }

    function getEntityUserJson(Produit $entity)
    {
        $ppp = $entity->getUserid();
        $ch = $this->getDoctrine()->getRepository('UserBundle:User')->find($ppp);
        return $ch->getId();;
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
        $user = $this->getUser();
        $product = new Produit();
        $product->setDate(new \DateTime());
        $product->setUserid($user);
        $product->setValidation(0);
        $form = $this->createForm(ProduitType::class, $product);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {


            $Category = $form['category']->getData();
            $product->setCategory($Category);
            $product->setPrice($form['price']->getData());
            $product->setDate(new \DateTime());
            if ( is_null($form['imgsrc']->getData()) ) {
                $product->setImgsrc('products.png');
            } else {
                try {$file = $request->files->get('productbundle_produit')['imgsrc'];
                    $uploads_directory = $this->getParameter('uploads_directory');
                    $fileName = $file->getClientOriginalName();
                    $file->move($uploads_directory, $fileName);
                    $product->setName($form['name']->getData());
                    $product->setImgsrc($fileName);
                }catch (\Exception $e){

                }

                //$product->setImgsrc($form['imgsrc']->getData());
            }
            $em = $this->getDoctrine()->getManager();
            $em->persist($product);
            $em->flush();
            $this->addFlash('success', 'Product added.');
            return $this->redirectToRoute('add_product');
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
    }

    public function deleteProductAdminAction($id)
    {

        $em = $this->getDoctrine()->getManager();
        $product = $em->getRepository(Produit::class)->find($id);
        $em->remove($product);
        $em->flush();
        return $this->redirectToRoute('get_products');

    }


    public function validateSellAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $product = $em->getRepository(Produit::class)->find($id);
        $product->setValidation(1);
        $em->persist($product);
        $em->flush();
        $this->addFlash('successSold', 'Product sold.');
        return $this->redirectToRoute('add_product');
    }

    public function addProductMobileAction(Request $request, $name, $price, $userId, $categoryName)
    {
        $user = $this->getDoctrine()->getManager()->getRepository('UserBundle:User')->find($userId);
        $cat = $this->getDoctrine()->getManager()->getRepository(Category::class)->findOneBy(["name" => $categoryName]);
        $em = $this->getDoctrine()->getManager();
        $product = new Produit();
        $product->setName($name);
        $product->setPrice($price);
        $product->setImgsrc("products.png");
        $product->setValidation(0);
        $product->setCategory($cat);
        $product->setDate(new \DateTime());
        $product->setUserid($user);
        $em->persist($product);
        $em->flush();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($product);
        return new JsonResponse($formatted);

    }

    public function allProductsMobileAction()
    {
        $em = $this->getDoctrine()->getManager();
        $prodcuts = $em->getRepository(Produit::class)->allProductMobile();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($prodcuts);
        return new JsonResponse($formatted);
    }

    public function deleteProductMobileAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $product = $em->getRepository(Produit::class)->find($id);
        $em->remove($product);
        $em->flush();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($product);
        return new JsonResponse($formatted);
    }

    public function getUserAction(Request $request, $id)
    {
        $user = $this->getDoctrine()->getManager()->getRepository('UserBundle:User')->find($id);
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($user);
        return new JsonResponse($formatted);
    }

    public function updateProductMobileAction(Request $request,$id, $name, $price, $userId, $categoryName,$validation)
    {
        $user = $this->getDoctrine()->getManager()->getRepository('UserBundle:User')->find($userId);
        $cat = $this->getDoctrine()->getManager()->getRepository(Category::class)->findOneBy(["name" => $categoryName]);
        $em = $this->getDoctrine()->getManager();
        $product = $em->getRepository(Produit::class)->find($id);
        $product->setName($name);
        $product->setPrice($price);
        $product->setImgsrc("products.png");
        $product->setValidation($validation);
        $product->setCategory($cat);
        $product->setDate(new \DateTime());
        $product->setUserid($user);
        $em->flush();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($product);
        return new JsonResponse($formatted);

    }

}
