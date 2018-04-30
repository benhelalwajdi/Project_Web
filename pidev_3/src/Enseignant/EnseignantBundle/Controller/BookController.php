<?php

namespace Enseignant\EnseignantBundle\Controller;

use blackknight467\StarRatingBundle\Form\RatingType;
use Enseignant\EnseignantBundle\Entity\Book;
use Enseignant\EnseignantBundle\Entity\Rating;
use Enseignant\EnseignantBundle\Form\BookType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Security;

class BookController extends Controller
{

    public function ajoutBAction(Request $request)
    {
        $Book = new Book();
        $form = $this->createForm(BookType::class, $Book);
        $us = $this->getUser()->getId();

        if ($form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $Book->uploadProfilePicture();
            $Book->setIduser($us);

            $em->persist($Book); // insert into table
            $em->flush(); //executer
            return $this->redirectToRoute('Liste7');
        }
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
            'routename'=>$routeName,
            'f' => $form->createView()
        );
        return $this->render('EnseignantEnseignantBundle:Book:A.html.twig',$data);

    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function searchBAction(Request $request)
    {
        $m = $this->getDoctrine()->getManager();
        $mark = $m->getRepository('EnseignantEnseignantBundle:Book')->findAll();

        if ($request->getMethod() == "POST") {
            $mark = $m->getRepository('EnseignantEnseignantBundle:Book')->findBy(array('nomauteur' => $request->get('nomauteur')));

        }
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
            'routename'=>$routeName,
            'm' => $mark
        );
        return $this->render('EnseignantEnseignantBundle:Book:cher.html.twig',$data);
    }

    public function supprimerBAction(Request $request,$id)
    {
        $em = $this->getDoctrine()->getManager();
        $mark = $em->getRepository('EnseignantEnseignantBundle:Book')->find($id);
        $em->remove($mark);
        $em->flush();
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
        return $this->redirectToRoute('Liste8');
    }


    /**
     * @param $id
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function modifierBAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $mark = $em->getRepository('EnseignantEnseignantBundle:Book')->find($id);
        $form = $this->createForm(BookType::class, $mark);
        if ($form->handleRequest($request)->isValid()) {
            $em->persist($mark);
            $em->flush();
            return $this->redirectToRoute('Liste8');
        }
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
            'routename'=>$routeName,
             'f' => $form->createView()
        );
        return $this->render('EnseignantEnseignantBundle:Book:A.html.twig',$data);
    }

    public function AfficherBAction(Request $request)
    {

        $m = $this->getDoctrine()->getManager();
        $rating = $m->getRepository('EnseignantEnseignantBundle:Rating')->avgrating();
        $mark = $m->getRepository('EnseignantEnseignantBundle:Book')->findAll();
        if ($request->getMethod() == "POST") {
            $mark = $m->getRepository('EnseignantEnseignantBundle:Book')->findBy(array('nomauteur' => $request->get('nomauteur')));

        }
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
            'routename'=>$routeName,
            'm' => $mark,
            'rating' => $rating

        );
        return $this->render('EnseignantEnseignantBundle:Book:aff.html.twig', $data);
    }


    public function infoAction(Request $request, $id)
    {
        $rating = new Rating();
        $m = $this->getDoctrine()->getManager();
        $mark = $m->getRepository('EnseignantEnseignantBundle:Book')->find($id);
        $form = $this->createFormBuilder($rating)
            ->add('rating', RatingType::class, [
                'label' => 'Rating'
            ])
            ->add('valider', SubmitType::class, array(
                'attr' => array(

                    'class' => 'btn btn-xs btn-primary'
                )))
            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $rating->setIdB($mark->getId());
            $m->persist($rating);
            $m->flush();
        }
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
            'routename'=>$routeName,
            'm' => $mark,
            'f' => $form->createView()
        );
        return $this->render('EnseignantEnseignantBundle:Book:info.html.twig',$data);
    }

}