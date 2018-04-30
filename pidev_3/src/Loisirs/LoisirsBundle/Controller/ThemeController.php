<?php

namespace Loisirs\LoisirsBundle\Controller;

use Loisirs\LoisirsBundle\Entity\Theme;
use Loisirs\LoisirsBundle\Form\ThemeForm;
use Loisirs\LoisirsBundle\Form\ThemeType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Security;

class ThemeController extends Controller
{
    public function AjoutThemeAction(Request $request)
    {
        $theme = new Theme();
        $Form = $this->createForm(ThemeType::class, $theme);
        $Form->handleRequest($request);
        if ($Form->isValid()) {
            //var_dump($Form->getData());
            $theme->UploadProfilePicture();
            $m = $this->getDoctrine()->getManager();
            $m->persist($theme);
            $m->flush();

            return $this->redirectToRoute('_affiche_theme');
        }
        return $this->render('LoisirsLoisirsBundle:Theme:ajout_theme.html.twig', array(
            'f' => $Form->createView()
        ));
    }

    public function AfficheThemeAction()
    {
        $m=$this->getDoctrine()->getManager();
        $theme=$m->getRepository('LoisirsLoisirsBundle:Theme')->findAll();

        return $this->render('LoisirsLoisirsBundle:Theme:affiche_theme.html.twig', array(
            'theme'=>$theme
        ));

    }
    public function SupprimerThemeAction($id)
    {
        $m=$this->getDoctrine()->getManager();
        $theme=$m->getRepository('LoisirsLoisirsBundle:Theme')->find($id);
        $m->remove($theme);
        $m->flush();
        return  $this->redirectToRoute('_affiche_theme');

    }
    public function ModifierThemeAction($id,Request $request)
    {
        $m=$this->getDoctrine()->getManager();
        $theme=$m->getRepository('LoisirsLoisirsBundle:Theme')->find($id);
        $form=$this->createForm(ThemeForm::class,$theme);
        if($form->handleRequest($request)->isValid()) {
            $m->persist($theme);
            $m->flush();
            return $this->redirectToRoute('_affiche_theme');

        }
        return $this->render('LoisirsLoisirsBundle:Theme:modif_theme.html.twig', array('f'=>$form->createView()));


    }
    public function AfficheClientThemeAction(Request $request)
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
        $m=$this->getDoctrine()->getManager();

        $theme=$m->getRepository('LoisirsLoisirsBundle:Theme')->findAll();
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
            'routename'=>$routeName,'theme'=>$theme
        );
        return $this->render('LoisirsLoisirsBundle:Theme:afficheclient_theme.html.twig',$data);
    }
}
