<?php

namespace EventsBundle\Controller;

use EventsBundle\Entity\Competition;
use EventsBundle\Entity\Competitionuser;
use EventsBundle\Entity\Events;
use EventsBundle\Form\CompetitionType;
use Proxies\__CG__\ProductBundle\Entity\Category;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class CompetitionController extends Controller
{
    public function GetCompetitionsAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        $competitions = $em->getRepository("EventsBundle:Competition")->findAll();
        if ($request->isMethod('POST')){
            $chaine=$request->get('search');
            $competitions = $em->getRepository("EventsBundle:Competition")->search($chaine);
        }


        return $this->render('@Events/Competition/get_competition.html.twig', array(
            'result' => $competitions,
            'connected' => $this->getUser()
        ));
    }
    public function AddParticipateAction($idcomp,$type){
        $em = $this->getDoctrine()->getManager();
        $result=$em->getRepository("EventsBundle:Competition")->VerifUserParticipated($idcomp,$this->getUser()->getId());
        if ($result!=0){
        return new JsonResponse("exists");
    }else{
        $competitions = $em->getRepository("EventsBundle:Competition")->find($idcomp);
        $participant= new Competitionuser();
        $participant->setIdu($this->getUser());
        $participant->setIdcomp($competitions);
        if ($type==1){
            $participant->setType('participant');
            $competitions->setNbrparticipant($competitions->getNbrparticipant()+1);
        }else{
            $participant->setType('Spectateur');
            $competitions->setNbrspec($competitions->getNbrspec()+1);
        }

        $em->persist($participant);
        $em->flush();
        return new JsonResponse('ajout');
    }

    }
    public function AddCompetitionsAction(Request $request)
    {
        $competition =new Competition();
        $competition->setIdu($this->getUser());
        $competition->setNbrspec(0);
        $competition->setNbrparticipant(0);
        $competition->setEtat(0);

        $Form=$this->createForm(CompetitionType::class,$competition);
        $Form->handleRequest($request);

        if ($Form->isSubmitted()&&$Form->isValid())
        {
            $em=$this->getDoctrine()->getManager();
            $em->persist($competition);
            $em->flush();
            return $this->redirectToRoute('get_competitions');
        }
        return $this->render('@Events/Competition/add_competition.html.twig', array(
            'competitionform'=>$Form->createView()
        ));
    }

    public function DeleteCompetitionAction($id)
    {
        $em=$this->getDoctrine()->getManager();
        $competition=$em->getRepository(Competition::class)->find($id);
        $em->remove($competition);
        $em->flush();
        return $this->redirectToRoute('get_competitions');
    }

    public function UpdateCompetitionAction($id,Request $request)
    {
        $em=$this->getDoctrine()->getManager();
        $competition=$em->getRepository(Competition::class)->find($id);
        $competition->setIdu($this->getUser());
        $competition->setNbrspec(0);
        $competition->setNbrparticipant(0);
        $competition->setEtat(0);

        $Form=$this->createForm(CompetitionType::class,$competition);
        $Form->handleRequest($request);
        if ($Form->isSubmitted())
        {
            $em->flush();
            return $this->redirectToRoute('get_competitions');
        }
        return $this->render('@Events/Competition/update_competition.html.twig', array(
            'competitionform'=>$Form->createView()
        ));
    }

    public function SingleCompetitionAction($id)
    {
        $em=$this->getDoctrine()->getManager();
        $events=$em->getRepository(Competition::class)->find($id);

        return $this->render('@Events/Competition/single_competition.html.twig', array(
            'single_event' => $events,
            'connected' => $this->getUser()
        ));
    }


    /*Mobile*/
    public function getAllEventsAction(){
        $result=$this->getDoctrine()->getManager()->getRepository(Competition::class)->findAll();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $events=$serializer->normalize($result);
        return new JsonResponse($events);
    }

    public function deleteEventsMobileAction($id)
    {
        $em=$this->getDoctrine()->getManager();
        $comp=$em->getRepository(Competition::class)->find($id);
        $em->remove($comp);
        $em->flush();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($comp);
        return new JsonResponse($formatted);
    }

    public function addCompetitionMobileAction($Namecomp,$Desccomp,$Nbrmaxspec,$Nbrmaxpar,$Location,$sday,$smonth,$syear,$eday,$emonth,$eyear,$Pricecomp,$Idcat,$Image_name,$IdU)
    {
        $em = $this->getDoctrine()->getManager();
        $user=$em->getRepository("UserBundle:User")->find($IdU);
        $category=$em->getRepository(Category::class)->find($Idcat);
        $competition = new Competition();

        $Startingdate = new \DateTime();
        $Startingdate->setDate($syear,$smonth,$sday);

        $Endingdate = new \DateTime();
        $Endingdate->setDate($eyear,$emonth,$eday);

        $competition->setNamecomp($Namecomp);
        $competition->setDesccomp($Desccomp);
        $competition->setNbrmaxspec($Nbrmaxspec);
        $competition->setNbrmaxpar($Nbrmaxpar);
        $competition->setLocation($Location);

        $competition->setStartingdate($Startingdate);
        $competition->setEndingdate($Endingdate);

        $competition->setPricecomp($Pricecomp);
        $competition->setIdcat($category);
        $competition->setImageName($Image_name);
        $competition->setIdu($user);

        $competition->setEtat(0);
        $competition->setNbrparticipant(0);
        $competition->setNbrspec(0);
        $competition->setLat("");
        $competition->setLng("");


        //var_dump($competition);


        $em->persist($competition);
        $em->flush();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($competition);
        //return new JsonResponse($formatted);
        return new JsonResponse($formatted);

    }

    public function editCompetitionMobileAction($id,$Namecomp,$Desccomp,$Nbrmaxspec,$Nbrmaxpar,$Location,$sday,$smonth,$syear,$eday,$emonth,$eyear,$Pricecomp,$Idcat,$Image_name,$IdU)
    {
        $em = $this->getDoctrine()->getManager();
        $user=$em->getRepository("UserBundle:User")->find($IdU);
        $category=$em->getRepository(Category::class)->find($Idcat);
        $competition=$em->getRepository(Competition::class)->find($id);

        $Startingdate = new \DateTime();
        $Startingdate->setDate($syear,$smonth,$sday);

        $Endingdate = new \DateTime();
        $Endingdate->setDate($eyear,$emonth,$eday);

        $competition->setNamecomp($Namecomp);
        $competition->setDesccomp($Desccomp);
        $competition->setNbrmaxspec($Nbrmaxspec);
        $competition->setNbrmaxpar($Nbrmaxpar);
        $competition->setLocation($Location);

        $competition->setStartingdate($Startingdate);
        $competition->setEndingdate($Endingdate);

        $competition->setPricecomp($Pricecomp);
        $competition->setIdcat($category);
        $competition->setImageName($Image_name);
        $competition->setIdu($user);

        $competition->setEtat(0);
        $competition->setNbrparticipant(0);
        $competition->setNbrspec(0);
        $competition->setLat("");
        $competition->setLng("");


        //var_dump($competition);



        $em->flush();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($competition);
        //return new JsonResponse($formatted);
        return new JsonResponse($formatted);

    }

}
