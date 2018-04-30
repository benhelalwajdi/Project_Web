<?php

namespace bsitterBundle\Controller;

use bsitterBundle\Entity\Abonnement;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Security;

class AbonnementsController extends Controller
{
    public function indexAction($name)
    {


        return $this->render('', array('name' => $name));
    }

    public function abonnerAction(Request $request)

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
        $abonnement = new Abonnement();
        $BabySitter = $this->getUser();
        $id = $request->attributes->get('id');
        $other = $em->getRepository('UserBundle:User')->findOneBy(array('id' => $id));
        $abonnement->setIdSuiveur($BabySitter)->setIdSuivi($other);

        $em->persist($abonnement);
        $em->flush();
        $referer = $request->headers->get('referer');
        if ($referer == NULL) {
            $url = $this->router->generate('AfficheBs');
        } else {
            $url = $referer;
        }
        return $this->redirect($url);
    }

    public function desabonnerAction(Request $request)
    {
        $BabySitter = $this->getUser();
        $id = $request->attributes->get('id');
        $em = $this->getDoctrine()->getManager();
        $abs = $em->getRepository('bsitterBundle:Abonnement')->findOneBy(array('idSuiveur' => $BabySitter->getId(), 'idSuivi' => $id));
        $em->remove($abs);
        $em->flush();
        $referer = $request->headers->get('referer');
        if ($referer == NULL) {
            $url = $this->router->generate('fallback_url');
        } else {
            $url = $referer;
        }
        return $this->redirect($url);
    }

    public function listeAbonneeAction(Request $request) //les personnes abonnées à moi
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
        $id = $this->getUser()->getId();
        $abonnees = $this->getListAbonne($request, $id, $em);
        return $this->render('@bsitter/Abonnement/listeabonnee.html.twig', array('us' => $this->getUser(), 'usr' => $abonnees, 'last_username' => $lastUsername,
            'error' => $error,
            'csrf_token' => $csrfToken,
            'routename'=>$routeName));
    }

    public function listeAbonnementAction(Request $request) //les personnes elli je suis abonneé à eux
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
        $id = $this->getUser()->getId();
        $abonnees = $this->getListAbonnement($request, $id, $em);
        return $this->render('@bsitter/Abonnement/listeabonnement.html.twig', array('us' => $this->getUser(), 'usr' => $abonnees,'last_username' => $lastUsername,
            'error' => $error,
            'csrf_token' => $csrfToken,
            'routename'=>$routeName));
    }



    static function getListAbonne(Request $request, $id, $em)
    {
        $BabySitter = $em->getRepository('bsitterBundle:BabySitter')->findOneBy(array('id' => $id));
        $abs = $em->getRepository('bsitterBundle:Abonnement')->findBy(array('idSuivi' => $BabySitter));
        $abonnees = array();
        foreach ($abs as $abonne) {
            $usr = $em->getRepository('UserBundle:User')->findOneBy(array('id' => $abonne->getIdSuiveur()));
            array_push($abonnees, $usr);
        }
        return $abonnees;
    }

    static function getListAbonnement(Request $request, $id, $em)
    {
        $BabySitter = $em->getRepository('UserBundle:User')->findOneBy(array('id' => $id));

        $abs = $em->getRepository('bsitterBundle:Abonnement')->findBy(array('idSuiveur' => $BabySitter));
        $abonnees = array();
        foreach ($abs as $abonne) {
            $usr = $em->getRepository('UserBundle:User')->findOneBy(array('id' => $abonne->getIdSuivi()));
            array_push($abonnees, $usr);
        }
        return $abonnees;
    }

    static function getlisteAbonneeCommun(Request $request, $myid, $id, $em)
    {
        $id = $request->attributes->get('id');
        $mesabonnees = self::getListAbonne($request, $myid, $em);
        $sesabonnees = self::getListAbonne($request, $id, $em);
        $array = array_intersect($mesabonnees, $sesabonnees);
        return $array;
    }
    static function getlisteAbonnementCommun(Request $request,$myid,$id,$em)
    {
        $id = $request->attributes->get('id');
        $mesabonnement =self::getListAbonnement($request, $myid, $em);
        $sesabonnement = self::getListAbonnement($request, $id, $em);
        $array= array_intersect($mesabonnement,$sesabonnement);
        return $array;
    }
}
