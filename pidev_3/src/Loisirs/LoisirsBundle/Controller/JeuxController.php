<?php

namespace Loisirs\LoisirsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Security;

class JeuxController extends Controller
{
    public function JeuxAction(Request $request)
    {
        $em=$this->getDoctrine()->getManager();
        $user = $this->getUser();
        $notifsaccepte=null;
        $notifsrefus=null;

        if($user!= null and $user->hasRole('ROLE_MEDECIN'))
        {
            $notifsaccepte = $em->getRepository('SantearticleBundle:notifarticle')->FindBy(array('etat'=>'accépté','etatnotif'=>0,'idmedecin'=>$user->getId()));
            $notifsrefus = $em->getRepository('SantearticleBundle:notifarticle')->FindBy(array('etat'=>'Refusé','etatnotif'=>0,'idmedecin'=>$user->getId()));
            $em->getRepository('SantearticleBundle:notifarticle')->Updatenotif($user->getId());
            $em->getRepository('SantearticleBundle:notifarticle')->Updatenotif($user->getId());
        }
        $pediatress = $em->getRepository('SanteSpecialisteBundle:MedecinSpecialiste')->nbmedecin("Pédiatre");
        $s = $em->getRepository('SanteSpecialisteBundle:MedecinSpecialiste')->nbmedecin("Orthophoniste");
        $a1 = $em->getRepository('SantearticleBundle:article')->findBestarticle("accepté");

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
        );
        return $this->render('LoisirsLoisirsBundle:Jeux:Jeux.html.twig',$data);
    }
}
