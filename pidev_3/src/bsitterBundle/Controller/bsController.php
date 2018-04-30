<?php

namespace bsitterBundle\Controller;

use UserBundle\Entity\User;
use bsitterBundle\Form\cvType;
use Endroid\QrCode\QrCode;
use MongoDB\Driver\Exception\AuthenticationException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Request;
use Endroid\QrCode\Bundle\QrCodeBundle;

class bsController extends Controller
{

    public function AfficheBsAction(\Symfony\Component\HttpFoundation\Request $request)
    {
        $session = $request->getSession();

        $authErrorKey = Security::AUTHENTICATION_ERROR;
        $lastUsernameKey = Security::LAST_USERNAME;

        // get the error if any (works with forward and redirect -- see below)
        if ($request->attributes->has($authErrorKey)) {
            $error = $request->attributes->get($authErrorKey);
        } elseif (null !== $session && $session->has($authErrorKey)) {
            $error = $session->get($authErrorKey);
            $session->remove($authErrorKey);
        } else {
            $error = null;
        }

        if (!$error instanceof AuthenticationException) {
            $error = null; // The value does not come from the security component.
        }

        // last username entered by the user
        $lastUsername = (null === $session) ? '' : $session->get($lastUsernameKey);

        $t = $session->getId();
        $csrfToken = $this->has('security.csrf.token_manager')
            ? $this->get('security.csrf.token_manager')->getToken('authenticate')->getValue()
            : null;

        $routeName = $request->get('_route');
        $m=$this->getDoctrine()->getManager();
        $bs=$m->getRepository('UserBundle:User')->findBs("a:1:{i:0;s:7:\"ROLE_BS\";}");
        $data=array(
            'last_username' => $lastUsername,
            'error' => $error,
            'csrf_token' => $csrfToken,
            'routename'=>$routeName,
            'bs'=> $bs
        );

        return $this->render('@bsitter/babysitter/afficherbabysitter.html.twig', $data);

    }

    function FindusrAdminAction(\Symfony\Component\HttpFoundation\Request $request)
    {
        $session = $request->getSession();

        $authErrorKey = Security::AUTHENTICATION_ERROR;
        $lastUsernameKey = Security::LAST_USERNAME;

        // get the error if any (works with forward and redirect -- see below)
        if ($request->attributes->has($authErrorKey)) {
            $error = $request->attributes->get($authErrorKey);
        } elseif (null !== $session && $session->has($authErrorKey)) {
            $error = $session->get($authErrorKey);
            $session->remove($authErrorKey);
        } else {
            $error = null;
        }

        if (!$error instanceof AuthenticationException) {
            $error = null; // The value does not come from the security component.
        }

        // last username entered by the user
        $lastUsername = (null === $session) ? '' : $session->get($lastUsernameKey);

        $csrfToken = $this->has('security.csrf.token_manager')
            ? $this->get('security.csrf.token_manager')->getToken('authenticate')->getValue()
            : null;

        $routeName = $request->get('_route');
        $data=array(
            'last_username' => $lastUsername,
            'error' => $error,
            'csrf_token' => $csrfToken,
            'routename'=>$routeName
        );

        $bs = new User();
        $em = $this->getDoctrine()->getManager();
        $id = $this->getUser()->getId();
        if ($request->isMethod('POST')) {
            $y = $request->get('rech');
            if ($y != "") {
                $query = $em->createQuery(
                    "SELECT bs
                      FROM UserBundle:User bs
                           WHERE (
                              bs.username LIKE :userlike
                                OR bs.nom LIKE :userlike 
                                  OR bs.prenom LIKE :userlike
                                    OR bs.ville LIKE :userlike
                                      OR bs.email LIKE :userlike
                                     )
                                     AND  bs.id  <> $id"
                )->setParameter('userlike', '%' . $y . '%');
                $bs = $query->getResult();
                return $this->render('@bsitter/DonneBs/recherche_babysitter.html.twig', array('bs' => $bs, 'last_username' => $lastUsername,
                    'error' => $error,
                    'csrf_token' => $csrfToken,
                    'routename'=>$routeName));
            }
        }
        $query = $em->createQuery(
            "SELECT bs
                      FROM UserBundle:User bs
                           WHERE bs.id  <> $id"
        );
        $usr = $query->getResult();

        return $this->render('@bsitter/babysitter/consulterbs.html.twig', array('users' => $usr, 'last_username' => $lastUsername,
            'error' => $error,
            'csrf_token' => $csrfToken,
            'routename'=>$routeName));
    }
    public function compteAction(Request $request, $id){
        $session = $request->getSession();

        $authErrorKey = Security::AUTHENTICATION_ERROR;
        $lastUsernameKey = Security::LAST_USERNAME;

        // get the error if any (works with forward and redirect -- see below)
        if ($request->attributes->has($authErrorKey)) {
            $error = $request->attributes->get($authErrorKey);
        } elseif (null !== $session && $session->has($authErrorKey)) {
            $error = $session->get($authErrorKey);
            $session->remove($authErrorKey);
        } else {
            $error = null;
        }

        if (!$error instanceof AuthenticationException) {
            $error = null; // The value does not come from the security component.
        }

        // last username entered by the user
        $lastUsername = (null === $session) ? '' : $session->get($lastUsernameKey);

        $csrfToken = $this->has('security.csrf.token_manager')
            ? $this->get('security.csrf.token_manager')->getToken('authenticate')->getValue()
            : null;

        $routeName = $request->get('_route');
        $data=array(
            'last_username' => $lastUsername,
            'error' => $error,
            'csrf_token' => $csrfToken,
            'routename'=>$routeName
        );

        $m= $this->getDoctrine()->getManager();
        $bs = $m->getRepository('UserBundle:User')->findId($id);
        $user=  $this->getUser()->getId();
        $abonne = AbonnementsController::getListAbonne($request, $id, $m);
        $abonnement = AbonnementsController::getListAbonnement($request, $id, $m);
        $abonneeencommun= AbonnementsController::getlisteAbonneeCommun($request,$this->getUser()->getId(),$id,$m);
        $abonnementencommun= AbonnementsController::getlisteAbonnementCommun($request,$this->getUser()->getId(),$id,$m);
        $info = ("le nom de ce baby sitter est : ".$this->getUser()->getId());
        $data =array(
            'use' =>$user,
            'bs' => $bs,
            'abonnement' =>$abonnement,
            'abonne' => $abonne,
            'abonnementencommun'=>$abonnementencommun,
            'abonneeencommun'=>$abonneeencommun,
            'qr'=>$info,
            'last_username' => $lastUsername,
            'error' => $error,
            'csrf_token' => $csrfToken,
            'routename'=>$routeName
        );
        return $this->render('@bsitter/babysitter/consulterbs.html.twig', $data);
    }


    public function setCVAction(\Symfony\Component\HttpFoundation\Request $request)
    {
        $session = $request->getSession();

        $authErrorKey = Security::AUTHENTICATION_ERROR;
        $lastUsernameKey = Security::LAST_USERNAME;

        // get the error if any (works with forward and redirect -- see below)
        if ($request->attributes->has($authErrorKey)) {
            $error = $request->attributes->get($authErrorKey);
        } elseif (null !== $session && $session->has($authErrorKey)) {
            $error = $session->get($authErrorKey);
            $session->remove($authErrorKey);
        } else {
            $error = null;
        }

        if (!$error instanceof AuthenticationException) {
            $error = null; // The value does not come from the security component.
        }

        // last username entered by the user
        $lastUsername = (null === $session) ? '' : $session->get($lastUsernameKey);

        $csrfToken = $this->has('security.csrf.token_manager')
            ? $this->get('security.csrf.token_manager')->getToken('authenticate')->getValue()
            : null;

        $routeName = $request->get('_route');
        $data=array(
            'last_username' => $lastUsername,
            'error' => $error,
            'csrf_token' => $csrfToken,
            'routename'=>$routeName
        );

        $id = $this->getUser()->getId();
        $em = $this->getDoctrine()->getManager();
        $usr=$em->getRepository('UserBundle:User')->findOneBy(array('id'=>$id));
        $form=$this->createForm(cvType::class,$usr);
        $form->handleRequest($request);
        if($form->isValid())
        {
            $em=$this->getDoctrine()->getManager();
            $em->persist($usr);
            $em->flush();
            return $this->redirectToRoute('cv');
        }
        return $this->render('@bsitter/sendCv.html.twig', array('us' => $this->getUser(),'f'=>$form->createView(),  'last_username' => $lastUsername,
            'error' => $error,
            'csrf_token' => $csrfToken,
            'routename'=>$routeName));
    }

}
