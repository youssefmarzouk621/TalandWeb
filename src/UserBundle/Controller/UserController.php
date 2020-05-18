<?php

namespace UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use UserBundle\Entity\User;

class UserController extends Controller
{

    public function allAction()
    {
        $tasks = $this->getDoctrine()->getManager()
            ->getRepository('UserBundle:User')
            ->findAll();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($tasks);
        return new JsonResponse($formatted);
    }
    public function finduserAction($email){
        $tasks = $this->getDoctrine()->getManager()
            ->getRepository('UserBundle:User')
            ->findOneBy(array('email' =>$email));
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($tasks);
        return new JsonResponse($formatted);
    }
    public function newAction(Request $request){
        $em = $this->getDoctrine()->getManager();
        $user = new User();
        $user -> setUsername($request->get('username'));
        $user -> setEmail($request->get('email'));
        $user -> setPassword($request->get('password'));
        //$user -> setRoles(array($request->get('role')));
        $user->setFirstname($request->get('firstname'));
        $user->setLastname($request->get('lastname'));
        $user->setBirthdate(0);
        $user->setSexe("");
        $user->setBiography("");
        // $user -> setNumtel($request->get('numTel'));
        // $user -> setCode($request->get('code'));
        $user->setStrike(0);

        $em->persist($user);
        $em->flush();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($user);
        return new JsonResponse($formatted);
    }
    public function editAction(Request $request,$id){
        $em = $this->getDoctrine()->getManager();
        $user=$em->getRepository("UserBundle:User")->find($id);
        $user -> setUsername($request->get('nom'));
        $user -> setEmail($request->get('email'));
        $user -> setPassword($request->get('password'));
        $user -> setFirstname($request->get('firstname'));
        $user -> setLastname($request->get('lastname'));
        $em->persist($user);
        $em->flush();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($user);
        return new JsonResponse($formatted);
    }

    public function loginMobileAction($username, $password)
    {
        $user_manager = $this->get('fos_user.user_manager');
        $factory = $this->get('security.encoder_factory');
        $data = [
            'type' => 'validation error',
            'title' => 'There was a validation error',
            'errors' => 'username or password invalide'
        ];
        $response = new JsonResponse($data, 400);
        $utilisateur = $user_manager->findUserByUsername($username);
        if (!$utilisateur)
            return $response;
        $encoder = $factory->getEncoder($utilisateur);
        $bool = ($encoder->isPasswordValid($utilisateur->getPassword(), $password, $utilisateur->getSalt())) ? "true" : "false";
        if ($bool == "true") {
            $role = $utilisateur->getRoles();
            $data = array('type' => 'Login succeed',
                'id' => $utilisateur->getId(),
                'Firstname' => $utilisateur->getFirstname(),
                'Lastname' => $utilisateur->getLastname(),
                'Image' => $utilisateur->getImageName(),
                'Email' => $utilisateur->getEmail(),
                'Username' => $utilisateur->getUsername(),
                // 'idSociete' => $utilisateur->getIdsociete()->getidSociete(),
            );
            $data2=array($data);
            $response = new JsonResponse($data2, 200);
            return $response;
        } else {
            return $response;
        }
    }






}