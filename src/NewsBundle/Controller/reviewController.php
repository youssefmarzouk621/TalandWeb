<?php

namespace NewsBundle\Controller;

use NewsBundle\Entity\review;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class reviewController extends Controller
{
    public function rateM($rate){

        $em = $this->getDoctrine()->getManager();
       // $article= $em->getRepository("NewsBundle:review")->find($id);
        $review=new review();
        $review->setRate($rate);
        $review->setEtat(0);
        $review->setIduser(1);
        $review->setIdarticle(1);
        $em->persist($review);
        $em->flush();
        $serializer=new Serializer([new ObjectNormalizer()]);
        $formatted=$serializer->normalize($review);
        return new JsonResponse($formatted);
    }


}
