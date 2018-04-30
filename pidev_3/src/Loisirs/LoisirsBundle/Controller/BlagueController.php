<?php

namespace Loisirs\LoisirsBundle\Controller;

use Loisirs\LoisirsBundle\Entity\Blague;
use Loisirs\LoisirsBundle\Form\BlagueType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Security;

class BlagueController extends Controller
{
    public function AjoutBlagueAction(request $request)
    {

        $blague=new Blague();
        $Form = $this->createForm(BlagueType::class, $blague);
        $Form->handleRequest($request);
        if ($Form->isValid()) {
            $time=new \DateTime();
            $time->format('H:i:s \O\n Y-m-d');
            $blague->setDate($time);
            $m = $this->getDoctrine()->getManager();
            $m->persist($blague);
            $m->flush();
            return $this->redirectToRoute('_affiche_blague');
        }
        return $this->render('LoisirsLoisirsBundle:Blague:ajout_blague.html.twig', array(
            'f' => $Form->createView()
        ));
    }


    public function AfficheBlagueAction()
    {
     /*   return $this->render('LoisirsLoisirsBundle:Blague:affiche_blague.html.twig', array(
            // ...
        ));
    */
        $m=$this->getDoctrine()->getManager();
        $blague=$m->getRepository('LoisirsLoisirsBundle:Blague')->findAll();

        return $this->render('LoisirsLoisirsBundle:Blague:affiche_blague.html.twig', array(
            'blague'=>$blague
        ));


    }

    public function SupprimerBlagueAction($id)
    {
        $m=$this->getDoctrine()->getManager();
        $blague=$m->getRepository('LoisirsLoisirsBundle:Blague')->find($id);
        $m->remove($blague);
        $m->flush();
        return  $this->redirectToRoute('_affiche_blague');

    }
    public function ModifierBlagueAction($id,Request $request)
    {
        $m=$this->getDoctrine()->getManager();
        $blague=$m->getRepository('LoisirsLoisirsBundle:Blague')->find($id);
        $form=$this->createForm(BlagueType::class,$blague);
        if($form->handleRequest($request)->isValid()) {
            $m->persist($blague);
            $m->flush();
            return $this->redirectToRoute('_affiche_blague');

        }
        return $this->render('LoisirsLoisirsBundle:Blague:modif_blague.html.twig', array('f'=>$form->createView()));


    }
    public function RechercherBlagueAction(Request $request)
    {
        $m=$this->getDoctrine()->getManager();
        $blague=$m->getRepository('LoisirsLoisirsBundle:Blague')->findAll();
        if($request->getMethod()=="POST") {

            $blague = $m->getRepository('LoisirsLoisirsBundle:Blague')->findBlague($request->get('titre'));

            return $this->render('LoisirsLoisirsBundle:Blague:recherche_blague.html.twig', array(
                // ...
                'blague' => $blague
            ));
        }
        return $this->render('LoisirsLoisirsBundle:Blague:recherche_blague.html.twig', array(
            // ...
            'blague'=>$blague
        ));

    }

    public function AfficheClientBlagueAction(Request $request)
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
        $m=$this->getDoctrine()->getManager();

        $blague=$m->getRepository('LoisirsLoisirsBundle:Blague')->findAll();
        if($request->getMethod()=="POST") {

            $blague = $m->getRepository('LoisirsLoisirsBundle:Blague')->findBlagueDate($request->get('date'));

            return $this->render('LoisirsLoisirsBundle:Blague:afficheclient_blague.html.twig', array(
                // ...
                'blague' => $blague,'notifsrefus'=>$notifsrefus,'notifsaccepte'=>$notifsaccepte,'p'=>$pediatress,'o'=>$s,'a1'=>$a1[0],'o'=>$s,'a2'=>$a1[1],'o'=>$s,'a3'=>$a1[2]
            ));
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
            'routename'=>$routeName,'blague'=>$blague
        );
        return $this->render('LoisirsLoisirsBundle:Blague:afficheclient_blague.html.twig', $data);
    }

}
