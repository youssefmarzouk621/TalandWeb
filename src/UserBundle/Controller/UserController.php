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
        $user -> setUsernameCanonical($user ->getUsername());
        $user -> setEmail($request->get('email'));
        $user -> setEmailCanonical($user -> getEmail());
        $user -> setEnabled(1);
        $user -> setSalt(NULL);
        $user -> setLastLogin(new \DateTime());
        $user -> setConfirmationToken(NULL);
        $user -> setPasswordRequestedAt(NULL);
        $user -> setPassword($request->get('password'));
        $user->setFirstname($request->get('firstname'));
        $user->setLastname($request->get('lastname'));
        $user->setBirthdate($request->get('birthdate'));
        $user->setPicture("");
        $user->setSexe("");
        $user->setBiography("user");
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
                'abc'=>$utilisateur->getPlainPassword(),
                'Firstname' => $utilisateur->getFirstname(),
                'Lastname' => $utilisateur->getLastname(),
                'Image' => $utilisateur->getPicture(),
                 'Email' => $utilisateur->getEmail(),
                  'Username' => $utilisateur->getUsername(),
                'Birthdate'=>$utilisateur->getBirthdate(),
                'Password' =>$utilisateur->getPassword()
                // 'idSociete' => $utilisateur->getIdsociete()->getidSociete(),
                );
                $data2=array($data);
            $response = new JsonResponse($data2, 200);
            return $response;
        } else {
            return $response;
        }
    }

    public function createUtilisateurAction(Request $request,$username,$firstname,$lastname,$email,$password)
    {
        $utilisateur= new User();
        $pwd = $request->get('plainPassword');

        $em = $this->getDoctrine()->getManager();
        //$societe = $em->getRepository('OpenQuantumBundle:Societe')->find($request->get('idSociete'));

        $utilisateur->setPassword($password);
        $utilisateur->setFirstname($firstname);
        $utilisateur->setLastname($lastname);
        $utilisateur->setEmail($email);
        $utilisateur->setUsername($username);
        $utilisateur->setSexe("");
       // $utilisateur->setRoles(true);
        $utilisateur->setEnabled(true);
        $utilisateur->setPicture("aa.png");
        $utilisateur->setBirthdate("11/11/11");
        $utilisateur->setBiography("aaa");
        $em = $this->getDoctrine()->getManager();
        $em->persist($utilisateur);
        $em->flush();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($utilisateur);
        return new JsonResponse($formatted);
    }







}
