<?php

namespace Loisirs\LoisirsBundle\Controller;
use Loisirs\LoisirsBundle\Form\BonplanAvisForm;
use Loisirs\LoisirsBundle\Form\BonplanForm;
use Loisirs\LoisirsBundle\Form\BonplanType;
use Symfony\Component\HttpFoundation\Request;
use Loisirs\LoisirsBundle\Entity\Bonplan;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Security;

class BonplanController extends Controller
{

    public function MapAction($id)
    {

        $m=$this->getDoctrine()->getManager();
        $bonplan=$m->getRepository('LoisirsLoisirsBundle:Bonplan')->find($id);
        $lng=$bonplan->getLng();
        $lat=$bonplan->getLat();


       return $this->render('LoisirsLoisirsBundle:Bonplan:map.html.twig'
            ,array('lat'=>$lat,'lng'=>$lng));
    }

    public function AjoutBonplanAction(Request $request)
    {
        $bonplan = new Bonplan();
        $Form = $this->createForm(BonplanType::class, $bonplan);
        $Form->handleRequest($request);
        if ($Form->isValid()) {
           //var_dump($Form->getData());
            $bonplan->UploadProfilePicture();
            $m = $this->getDoctrine()->getManager();
            $bonplan->setRating(0);
            $m->persist($bonplan);
            $m->flush();

            return $this->redirectToRoute('_affiche_bonplan');
        }
        return $this->render('LoisirsLoisirsBundle:Bonplan:ajout_bonplan.html.twig', array(
            'f' => $Form->createView()
        ));
    }

    public function AfficheBonplanAction()
    {
        $m=$this->getDoctrine()->getManager();
        $bonplan=$m->getRepository('LoisirsLoisirsBundle:Bonplan')->findAll();

        return $this->render('LoisirsLoisirsBundle:Bonplan:affiche_bonplan.html.twig', array(
            'bonplan'=>$bonplan
        ));

    }
    public function SupprimerBonplanAction($id)
    {
        $m=$this->getDoctrine()->getManager();
        $bonplan=$m->getRepository('LoisirsLoisirsBundle:Bonplan')->find($id);
        $m->remove($bonplan);
        $m->flush();
        return  $this->redirectToRoute('_affiche_bonplan');

    }
    public function ModifierBonplanAction($id,Request $request)
    {
        $m=$this->getDoctrine()->getManager();
        $bonplan=$m->getRepository('LoisirsLoisirsBundle:Bonplan')->find($id);
        $form=$this->createForm(BonplanForm::class,$bonplan);
        if($form->handleRequest($request)->isValid()) {
            $m->persist($bonplan);
            $m->flush();
            return $this->redirectToRoute('_affiche_bonplan');

        }
        return $this->render('LoisirsLoisirsBundle:Bonplan:modif_bonplan.html.twig', array('f'=>$form->createView()));


    }
    public function RechercherBonplanAction(Request $request)
    {
        $m=$this->getDoctrine()->getManager();
        $bon=$m->getRepository('LoisirsLoisirsBundle:Bonplan')->findAll();
        if($request->getMethod()=="POST") {

            $bon = $m->getRepository('LoisirsLoisirsBundle:Bonplan')->findBonplan($request->get('region'));

            return $this->render('LoisirsLoisirsBundle:Bonplan:recherche_bonplan.html.twig', array(
                // ...
                'bonplan' => $bon
            ));
        }
        return $this->render('LoisirsLoisirsBundle:Bonplan:recherche_bonplan.html.twig', array(
            // ...
            'bonplan'=>$bon
        ));

    }
    public function AfficheClientBonplanAction(Request $request)
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
        $bonplan=$m->getRepository('LoisirsLoisirsBundle:Bonplan')->findOrdreBonplan();

        if($request->getMethod()=="POST") {

            $bon = $m->getRepository('LoisirsLoisirsBundle:Bonplan')->findBonplanNom($request->get('nom'));
            return $this->render('LoisirsLoisirsBundle:Bonplan:afficheclient_bonplan.html.twig', array(
                // ...
                'bonplan' => $bon,'notifsrefus'=>$notifsrefus,'notifsaccepte'=>$notifsaccepte,'p'=>$pediatress,'o'=>$s,'a1'=>$a1[0],'o'=>$s,'a2'=>$a1[1],'o'=>$s,'a3'=>$a1[2]
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
            'routename'=>$routeName,'bonplan'=>$bonplan
        );

        return $this->render('LoisirsLoisirsBundle:Bonplan:afficheclient_bonplan.html.twig', $data

        );

    }

    public function AvisBonplanAction($id,Request $request)
    {
        $m=$this->getDoctrine()->getManager();
        $bonplan=$m->getRepository('LoisirsLoisirsBundle:Bonplan')->find($id);
        $x=$bonplan->getRating();
        $form=$this->createForm(BonplanAvisForm::class,$bonplan);
        if($form->handleRequest($request)->isValid()) {
            $y=$bonplan->getRating();

            $bonplan->setRating($x+$y);
            $m->persist($bonplan);
            $m->flush();
            return $this->redirectToRoute('_afficheclient_bonplan');

        }
        return $this->render('LoisirsLoisirsBundle:Bonplan:avis_bonplan.html.twig', array('f'=>$form->createView(),'image'=>$bonplan->getNomImage())


        );


    }


}
