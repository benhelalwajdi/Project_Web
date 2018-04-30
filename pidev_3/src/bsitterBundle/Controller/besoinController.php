<?php

namespace bsitterBundle\Controller;

use bsitterBundle\Entity\besoin;
use bsitterBundle\Form\besoinType;
use bsitterBundle\Repository\BesoinRepository;
use MongoDB\Driver\Exception\AuthenticationException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Request;


class besoinController extends Controller
{
    public function ajouterAction(Request $request )

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

        $em = $this->getDoctrine()->getManager();
        $besoin = new besoin();
        $user = $this->getUser();
        $idBS= $user->getId();
        $id = $request->attributes->get('id');
        $other = $em->getRepository('bsitterBundle:BabySitter')->findOneBy(array('id' => $id));
        if($request->getMethod()=="POST")
        {
            date_default_timezone_set('Africa/Tunis');
            $y=$request->get('besoin');
            $date = new \DateTime();
            $besoin->setCreateAt($date);
            $besoin->setIdbs($user);
            $besoin->setDescriptionDuBesoin($y);
            $besoin->setIdp($other);
            $em->persist($besoin);
            $em->flush();
            return $this->redirectToRoute('AfficheBesoin', array( 'last_username' => $lastUsername,
                'error' => $error,
                'csrf_token' => $csrfToken,
                'routename'=>$routeName));
        }
        return $this->render('@bsitter/besoin/ajout.html.twig',array( 'last_username' => $lastUsername,
            'error' => $error,
            'csrf_token' => $csrfToken,
            'routename'=>$routeName));
    }

    public function afficheAction(Request $request)

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

        $manager=$this->getDoctrine()->getManager();

        $bs=$manager->getRepository('bsitterBundle:besoin')->findAll();
        return $this->render('@bsitter/besoin/Affiche.html.twig', array('besoin'=>$bs,  'last_username' => $lastUsername,
            'error' => $error,
            'csrf_token' => $csrfToken,
            'routename'=>$routeName));


    }

    public function modifierAction($id,Request $request)

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

        $em = $this->getDoctrine()->getManager();
        $besoin = $em->getRepository('bsitterBundle:besoin')->find($id);
        $ModelForm = $this->createForm(besoinType::class, $besoin);
        $ModelForm->handleRequest($request);
        if ($ModelForm->isValid()) {
            $em->persist($besoin);
            $em->flush();
            return $this->redirectToRoute('AfficheBesoin');
        }
        return $this->render('@bsitter/besoin/modifier.html.twig', array('f' => $ModelForm->createView(),  'last_username' => $lastUsername,
            'error' => $error,
            'csrf_token' => $csrfToken,
            'routename'=>$routeName));

    }


    public function affichepAction(Request $request)
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

        $manager=$this->getDoctrine()->getManager();
        $user= $this->getUser();
        $userr= $manager->getRepository('bsitterBundle:BabySitter')->find($user);
        $bs=$manager->getRepository('bsitterBundle:besoin')->find(array('idp'=>$userr));
        return $this->render('@bsitter/besoin/Affiche.html.twig', array('besoin'=>$bs,  'last_username' => $lastUsername,
            'error' => $error,
            'csrf_token' => $csrfToken,
            'routename'=>$routeName));
    }
}
