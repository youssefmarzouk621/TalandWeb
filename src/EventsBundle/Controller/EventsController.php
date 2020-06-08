<?php

namespace EventsBundle\Controller;

use EventsBundle\Entity\Events;
use EventsBundle\Entity\Eventuser;
use EventsBundle\Form\EventsType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class EventsController extends Controller
{
    public function GetEventsAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        $Events = $em->getRepository("EventsBundle:Events")->findAll();
        if ($request->isMethod('POST')){
            $chaine=$request->get('search');
            $Events = $em->getRepository("EventsBundle:Events")->searchE($chaine);
        }


        return $this->render('@Events/Events/get_Events.html.twig', array(
            'result' => $Events,
            'connected' => $this->getUser()
        ));
    }

    public function AddSpecAction($idevent){
        $em = $this->getDoctrine()->getManager();
        $result=$em->getRepository("EventsBundle:Events")->VerifUserSpec($idevent,$this->getUser()->getId());
        if ($result!=0){
            return new JsonResponse("exists");
        }else{
            $Events = $em->getRepository("EventsBundle:Events")->find($idevent);
            $participant= new Eventuser();
            $participant->setIdu($this->getUser());
            $participant->setIdevent($idevent);
            $Events->setNbrspectateurevent($Events->getNbrspectateurevent()+1);


            $em->persist($participant);
            $em->flush();
            return new JsonResponse('ajout');
        }

    }

    public function SingleEventAction($id)
    {
        $em=$this->getDoctrine()->getManager();
        $events=$em->getRepository(Events::class)->find($id);

        return $this->render('@Events/Events/single_event.html.twig', array(
            'single_event' => $events,
            'connected' => $this->getUser()
        ));
    }

    public function AddEventsAction(Request $request)
    {
        $Events =new Events();
        $Events->setIdu($this->getUser());
        $Events->setNbrspectateurevent(0);
        $Events->setEtatEvent(0);

        $Form=$this->createForm(EventsType::class,$Events);
        $Form->handleRequest($request);

        if ($Form->isSubmitted()&&$Form->isValid())
        {
            $em=$this->getDoctrine()->getManager();
            $em->persist($Events);
            $em->flush();
            return $this->redirectToRoute('get_events');
        }
        return $this->render('@Events/Events/add_Events.html.twig', array(
            'Eventsform'=>$Form->createView()
        ));
    }

    public function DeleteEventsAction($id)
    {
        $em=$this->getDoctrine()->getManager();
        $Events=$em->getRepository(Events::class)->find($id);
        $em->remove($Events);
        $em->flush();
        return $this->redirectToRoute('get_events');
    }

    public function UpdateEventsAction($id,Request $request)
    {
        $em=$this->getDoctrine()->getManager();
        $Events=$em->getRepository(Events::class)->find($id);
        $Events->setIdu($this->getUser());
        $Events->setNbrspectateurevent(0);
        $Events->setEtatEvent(0);

        $Form=$this->createForm(EventsType::class,$Events);
        $Form->handleRequest($request);
        if ($Form->isSubmitted())
        {
            $em->flush();
            return $this->redirectToRoute('get_events');
        }
        return $this->render('@Events/Events/update_Events.html.twig', array(
            'Eventsform'=>$Form->createView()
        ));
    }




    /*Mobile*/
    public function getAllEventsAction(){
        $result=$this->getDoctrine()->getManager()->getRepository(Events::class)->findAll();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $events=$serializer->normalize($result);
        return new JsonResponse($events);
    }

    public function deleteEventsMobileAction($id)
    {
        $em=$this->getDoctrine()->getManager();
        $comp=$em->getRepository(Events::class)->find($id);
        $em->remove($comp);
        $em->flush();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($comp);
        return new JsonResponse($formatted);
    }

    public function addEventsMobileAction($Namecomp,$Desccomp,$Nbrmaxspec,$Nbrmaxpar,$Location,$sday,$smonth,$syear,$eday,$emonth,$eyear,$Pricecomp,$Idcat,$Image_name,$IdU)
    {
        $em = $this->getDoctrine()->getManager();
        $user=$em->getRepository("UserBundle:User")->find($IdU);
        $category=$em->getRepository(Category::class)->find($Idcat);
        $Events = new Events();

        $Startingdate = new \DateTime();
        $Startingdate->setDate($syear,$smonth,$sday);

        $Endingdate = new \DateTime();
        $Endingdate->setDate($eyear,$emonth,$eday);

        $Events->setNamecomp($Namecomp);
        $Events->setDesccomp($Desccomp);
        $Events->setNbrmaxspec($Nbrmaxspec);
        $Events->setNbrmaxpar($Nbrmaxpar);
        $Events->setLocation($Location);

        $Events->setStartingdate($Startingdate);
        $Events->setEndingdate($Endingdate);

        $Events->setPricecomp($Pricecomp);
        $Events->setIdcat($category);
        $Events->setImageName($Image_name);
        $Events->setIdu($user);

        $Events->setEtat(0);
        $Events->setNbrparticipant(0);
        $Events->setNbrspec(0);
        $Events->setLat("");
        $Events->setLng("");


        //var_dump($Events);


        $em->persist($Events);
        $em->flush();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($Events);
        //return new JsonResponse($formatted);
        return new JsonResponse($formatted);

    }

    public function editEventsMobileAction($id,$Namecomp,$Desccomp,$Nbrmaxspec,$Nbrmaxpar,$Location,$sday,$smonth,$syear,$eday,$emonth,$eyear,$Pricecomp,$Idcat,$Image_name,$IdU)
    {
        $em = $this->getDoctrine()->getManager();
        $user=$em->getRepository("UserBundle:User")->find($IdU);
        $category=$em->getRepository(Category::class)->find($Idcat);
        $Events=$em->getRepository(Events::class)->find($id);

        $Startingdate = new \DateTime();
        $Startingdate->setDate($syear,$smonth,$sday);

        $Endingdate = new \DateTime();
        $Endingdate->setDate($eyear,$emonth,$eday);

        $Events->setNamecomp($Namecomp);
        $Events->setDesccomp($Desccomp);
        $Events->setNbrmaxspec($Nbrmaxspec);
        $Events->setNbrmaxpar($Nbrmaxpar);
        $Events->setLocation($Location);

        $Events->setStartingdate($Startingdate);
        $Events->setEndingdate($Endingdate);

        $Events->setPricecomp($Pricecomp);
        $Events->setIdcat($category);
        $Events->setImageName($Image_name);
        $Events->setIdu($user);

        $Events->setEtat(0);
        $Events->setNbrparticipant(0);
        $Events->setNbrspec(0);
        $Events->setLat("");
        $Events->setLng("");


        //var_dump($Events);



        $em->flush();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($Events);
        //return new JsonResponse($formatted);
        return new JsonResponse($formatted);

    }
}
