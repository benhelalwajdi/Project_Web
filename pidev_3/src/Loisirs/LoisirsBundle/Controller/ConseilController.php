<?php

namespace Loisirs\LoisirsBundle\Controller;

use Loisirs\LoisirsBundle\Entity\Conseil;
use Loisirs\LoisirsBundle\Form\ConseilType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Security;

class ConseilController extends Controller
{
    public function AjoutConseilAction(request $request)
    {

        $conseil=new Conseil();
        $Form = $this->createForm(ConseilType::class, $conseil);
        $Form->handleRequest($request);
        if ($Form->isValid()) {
            $time=new \DateTime();
            $time->format('H:i:s \O\n Y-m-d');
            $conseil->setDate($time);
            $m = $this->getDoctrine()->getManager();
            $m->persist($conseil);
            $m->flush();
            return $this->redirectToRoute('_affiche_conseil');
        }
        return $this->render('LoisirsLoisirsBundle:Conseil:ajout_conseil.html.twig', array(
            'f' => $Form->createView()
        ));
    }


    public function AfficheConseilAction()
    {
        $m=$this->getDoctrine()->getManager();
        $conseil=$m->getRepository('LoisirsLoisirsBundle:Conseil')->findAll();

        return $this->render('LoisirsLoisirsBundle:Conseil:affiche_conseil.html.twig', array(
            'conseil'=>$conseil
        ));


    }

    public function SupprimerConseilAction($id)
    {
        $m=$this->getDoctrine()->getManager();
        $conseil=$m->getRepository('LoisirsLoisirsBundle:Conseil')->find($id);
        $m->remove($conseil);
        $m->flush();
        return  $this->redirectToRoute('_affiche_conseil');

    }
    public function ModifierConseilAction($id,Request $request)
    {
        $m=$this->getDoctrine()->getManager();
        $conseil=$m->getRepository('LoisirsLoisirsBundle:Conseil')->find($id);
        $form=$this->createForm(ConseilType::class,$conseil);
        if($form->handleRequest($request)->isValid()) {
            $m->persist($conseil);
            $m->flush();
            return $this->redirectToRoute('_affiche_conseil');

        }
        return $this->render('LoisirsLoisirsBundle:Conseil:modif_conseil.html.twig', array('f'=>$form->createView()));
}
    public function AfficheClientConseilAction( Request $request){
        $m=$this->getDoctrine()->getManager();
        $conseil=$m->getRepository('LoisirsLoisirsBundle:Conseil')->findConseilJour();
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
            'routename'=>$routeName,'conseil'=>$conseil
        );

        return $this->render('LoisirsLoisirsBundle:Conseil:afficheclient_conseil.html.twig',$data
        );
    }



}
