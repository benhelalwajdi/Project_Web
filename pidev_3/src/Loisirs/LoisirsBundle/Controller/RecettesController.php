<?php

namespace Loisirs\LoisirsBundle\Controller;

use Loisirs\LoisirsBundle\Entity\Recette;
use Loisirs\LoisirsBundle\Form\RecetteForm;
use Loisirs\LoisirsBundle\Form\RecetteType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Security;

class RecettesController extends Controller
{
    public function AjoutRecetteAction(Request $request)
    {
        $recette = new Recette();
        $Form = $this->createForm(RecetteType::class, $recette);
        $Form->handleRequest($request);
        if ($Form->isValid()) {
            //var_dump($Form->getData());
            $recette->UploadProfilePicture();
            $recette->uploadProfileVideo();
            $m = $this->getDoctrine()->getManager();
            $m->persist($recette);
            $m->flush();

            return $this->redirectToRoute('_affiche_recette');
        }
        return $this->render('LoisirsLoisirsBundle:Recette:ajout_recette.html.twig', array(
            'f' => $Form->createView()
        ));
    }

    public function AfficheRecetteAction()
    {
        $m=$this->getDoctrine()->getManager();
        $recette=$m->getRepository('LoisirsLoisirsBundle:Recette')->findAll();

        return $this->render('LoisirsLoisirsBundle:Recette:affiche_recette.html.twig', array(
            'recette'=>$recette
        ));

    }
    public function SupprimerRecetteAction($id)
    {
        $m=$this->getDoctrine()->getManager();
        $recette=$m->getRepository('LoisirsLoisirsBundle:Recette')->find($id);
        $m->remove($recette);
        $m->flush();
        return  $this->redirectToRoute('_affiche_recette');

    }
    public function ModifierRecetteAction($id,Request $request)
    {
        $m=$this->getDoctrine()->getManager();
        $recette=$m->getRepository('LoisirsLoisirsBundle:Recette')->find($id);
        $form=$this->createForm(RecetteForm::class,$recette);
        if($form->handleRequest($request)->isValid()) {
            $m->persist($recette);
            $m->flush();
            return $this->redirectToRoute('_affiche_recette');

        }
        return $this->render('LoisirsLoisirsBundle:Recette:modif_recette.html.twig', array('f'=>$form->createView()));


    }
    public function RechercherRecetteAction(Request $request)
    {
        $m=$this->getDoctrine()->getManager();
        $recette=$m->getRepository('LoisirsLoisirsBundle:Recette')->findAll();
        if($request->getMethod()=="POST") {

            $recette = $m->getRepository('LoisirsLoisirsBundle:Recette')->findRecette($request->get('nom'));
            return $this->render('LoisirsLoisirsBundle:Recette:recherche_recette.html.twig', array(
                // ...
                'recette' => $recette
            ));
        }
        return $this->render('LoisirsLoisirsBundle:Recette:recherche_recette.html.twig', array(
            // ...
            'recette'=>$recette
        ));

    }
    public function AfficheClientRecetteAction(Request $request)
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

        $recette=$m->getRepository('LoisirsLoisirsBundle:Recette')->findAll();
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
            'routename'=>$routeName,'recette'=>$recette
        );

        return $this->render('LoisirsLoisirsBundle:Recette:afficheclient_recette.html.twig',$data
        );
    }
    public function AfficheDetailRecetteAction($id)
    {
        $m=$this->getDoctrine()->getManager();

        $recette=$m->getRepository('LoisirsLoisirsBundle:Recette')->find($id);
        return $this->render('LoisirsLoisirsBundle:Recette:affichedetail_recette.html.twig', array('recette'=>$recette));
    }
}
