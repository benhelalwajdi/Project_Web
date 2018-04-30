<?php

namespace bsitterBundle\Controller;

use bsitterBundle\Entity\BabySitter;
use bsitterBundle\Form\imageType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Security;
use bsitterBundle\Form\babysitterType;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('bsitterBundle:Default:index.html.twig');
    }

    public function modifierdonneAction(Request $request)
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
        $usr = $em->getRepository('UserBundle:User')->find($id);
        $usermanager = $this->get('fos_user.user_manager');
        $ModelForm = $this->createForm(babysitterType::class, $usr);
        $ModelForm->handleRequest($request);
        if ($ModelForm->isValid()) {
            $usermanager->updateUser($usr);
        }
        return $this->render('@bsitter/DonneBs/modif.html.twig', array('f' => $ModelForm->createView(), 'us' => $usr, 'last_username' => $lastUsername,
            'error' => $error,
            'csrf_token' => $csrfToken,
            'routename'=>$routeName));

    }


    public function setImageAction(Request $request)
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
        $form=$this->createForm(imageType::class,$usr);
        $form->handleRequest($request);
        if($form->isValid())
        {
            $em=$this->getDoctrine()->getManager();
            $em->persist($usr);
            $em->flush();
            return $this->redirectToRoute('img');
        }
        return $this->render('@bsitter/uploadImage.html.twig', array('us' => $this->getUser(),'f'=>$form->createView(),             'last_username' => $lastUsername,
            'error' => $error,
            'csrf_token' => $csrfToken,
            'routename'=>$routeName
        ));
    }
}
