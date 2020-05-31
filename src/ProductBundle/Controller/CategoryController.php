<?php

namespace ProductBundle\Controller;

use ProductBundle\Entity\Category;
use ProductBundle\Form\CategoryType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class CategoryController extends Controller
{
    public function getCategoriesAction()
    {

$category=new Category();

        $em = $this->getDoctrine()->getManager();
//        $product = $em->getRepository('ProductBundle:Produit')->findAll();
        $category = $em->getRepository(Category::class)->findAll();

          return $this->render('@Product/Admin/get_category.html.twig', array('categories' => $category));
    }


    public function addCategoryAction(Request $request)
    {


        $category=new Category();


        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $category->setName($form['name']->getData());
            $Category = $form['idcategorymother']->getData();
            if ($Category->getId()!=1)
            $category->setIdcategorymother($Category->getId());
            else
                $category->setIdcategorymother(null);
            $em = $this->getDoctrine()->getManager();
            $em->persist($category);
            $em->flush();
            $this->addFlash('success', 'Product added.');
            return $this->redirectToRoute('category_add');
        }
        return $this->render('@Product/Admin/add_category.html.twig', array(
            'categoryForm' => $form->createView()));
    }

    public function deleteCategoryAction($id, Request $request)
    {
        if ($this->isCsrfTokenValid('delete' . $id, $request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $category = $em->getRepository(Category::class)->find($id);
            $em->remove($category);
            $em->flush();
            return $this->redirectToRoute('category_get');
        }
    }


    public function getCategoriesMobileAction()
    {
        $em = $this->getDoctrine()->getManager();
        $category = $em->getRepository(Category::class)->findAll();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($category);
        return new JsonResponse($formatted);
    }
}
