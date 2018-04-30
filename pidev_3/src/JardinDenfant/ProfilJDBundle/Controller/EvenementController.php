<?php

namespace JardinDenfant\ProfilJDBundle\Controller;

use JardinDenfant\ProfilJDBundle\Entity\Evenement;
use JardinDenfant\ProfilJDBundle\Entity\ProfilJD;
use JardinDenfant\ProfilJDBundle\Form\EvenementType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\VarDumper\VarDumper;
use JardinDenfant\ProfilJDBundle\Entity\UserEvents;

class EvenementController extends Controller
{
    public function ajoutEAction(Request $request)
    {

        $e = new Evenement();
        $user = $this->getUser();
        $id = $user->getId();
        $form = $this->createForm(EvenementType::class, $e);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {

            $file = $form['image']->getData();

            $file->move("images/", $file->getClientOriginalName());
            $e->setImage($file->getClientOriginalName());
            $em = $this->getDoctrine()->getManager();
            $num=$em->getRepository('JardinDenfantProfilJDBundle:ProfilJD')->findOneBy(array('id'=>$id));
            $e->setNumAuth($num->getNumauth());
            //exit(VarDumper::dump($num->getNumauth()));

            $em->persist($e);
            $em->flush();
            return $this->redirectToRoute('affichEventsParJardin');
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
        $data = array(
            'last_username' => $lastUsername,
            'error' => $error,
            'csrf_token' => $csrfToken,
            'routename' => $routeName,
            'form' => $form->createView()
        );



        return $this->render('JardinDenfantProfilJDBundle:Evenement:ajout_e.html.twig', $data);

    }

    public function modifEAction($ide, Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        $mark = $em->getRepository('JardinDenfantProfilJDBundle:Evenement')->find($ide);
        $form = $this->createForm(EvenementType::class, $mark);

        if ($form->handleRequest($request)->isValid()) {
            $file = $form['image']->getData();

            $file->move("images/", $file->getClientOriginalName());
            $mark->setImage($file->getClientOriginalName());
            $em->persist($mark);
            $em->flush();
            return $this->redirectToRoute('affichEventsParJardin');
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
        $data = array(
            'last_username' => $lastUsername,
            'error' => $error,
            'csrf_token' => $csrfToken,
            'routename' => $routeName,
            'form' => $form->createView()
        );

        return $this->render('JardinDenfantProfilJDBundle:Evenement:modif_e.html.twig', $data);
    }

    public function supprimeEAction($ide)
    {

        $em = $this->getDoctrine()->getManager();
        $mark = $em->getRepository('JardinDenfantProfilJDBundle:Evenement')->find($ide);
//$ue= $mark->getUserevents();
       // exit(VarDumper::dump($ue));
     $userE= $em->getRepository('JardinDenfantProfilJDBundle:Evenement')->deleteUsersEventss($ide);


        foreach ($userE as $v) {

            $em->remove($v);
            $em->flush();



        }
        //exit(VarDumper::dump($userE));
       // $mark-> setUserevents(null) ;
        //$mark
       //
       // $em->remove($userE);

        $em->remove($mark);
        $em->flush();

        return $this->redirectToRoute('afficher_e');


    }

    public function rechercheEAction(Request $request)
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
        $data = array(
            'last_username' => $lastUsername,
            'error' => $error,
            'csrf_token' => $csrfToken,
            'routename' => $routeName,
        );

        return $this->render('JardinDenfantProfilJDBundle:Evenement:recherche_e.html.twig', array(// ...
        ));
    }

    public function afficherEAction(Request $request)
    {


        $em = $this->getDoctrine()->getManager();
        $ev = $em->getRepository("JardinDenfantProfilJDBundle:Evenement")->triEventsByDate();
       // $ev1= $em->getRepository("JardinDenfantProfilJDBundle:Evenement")->findBy();
        $user = $this->getUser();
        $id = $user->getId();
       // $num=$em->getRepository('JardinDenfantProfilJDBundle:Evenement')->findOneBy(array('ide'=>$ev));
        $useins=$em->getRepository('JardinDenfantProfilJDBundle:UserEvents')->findevn($id);
        $tab=array();
        foreach ($ev as $v) {

            foreach ($useins as $u) {

        if ($v->getIde() == $u->getEvenement()->getIde())
        {
            $tab[]=$v->getIde();
        }
            }

    }


       // $i= $useins->getUser()->getId();
        //$e=$useins->getEvenement()->getIde();
       // exit(VarDumper::dump($e));
        //$UE=$em->getRepository('JardinDenfantProfilJDBundle:UserEvents')->findUsersEvents($i,$e);

       // exit(VarDumper::dump($UE));

        //exit(VarDumper::dump($i));
     //  $idUE= $UE->getUser()->getId();
       // exit(VarDumper::dump($UE));
      /*if($UE == null){
            $var=true;
        }
        else
        {
            $var=false;
        }
*/

        /**
         * @var  $paginator \Knp\Component\Pager\Paginator
         */
        $paginator  = $this->get('knp_paginator');

        $evts=$paginator->paginate(
            $ev,
            $request->query->getInt('page',1),
            $request->query->getInt('limit',3)
        );
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
        $data = array(
            'last_username' => $lastUsername,
            'error' => $error,
            'csrf_token' => $csrfToken,
            'routename' => $routeName,
            "evts" => $evts,
            "useins"=>$useins,
            'tab'=>$tab,
        );


        return $this->render('JardinDenfantProfilJDBundle:Evenement:afficher_e.html.twig', $data);
    }


    public function calanderAction(Request $request)
    {


        $em = $this->getDoctrine()->getManager();
        $ev = $em->getRepository("JardinDenfantProfilJDBundle:Evenement")->findAll();
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
        $data = array(
            'last_username' => $lastUsername,
            'error' => $error,
            'csrf_token' => $csrfToken,
            'routename' => $routeName,
            "ev" => $ev
        );
        return $this->render('JardinDenfantProfilJDBundle:Evenement:test.html.twig', $data);
    }

    public function loadCalendrierDataAction( )
    {

        $em = $this->getDoctrine()->getManager();
        //Liste des categories
        /*$listCategories = $em->getRepository('PiEventBundle:Categorie')->findAll();
        $listCategorieJson = array();
        foreach ($listCategories as $categorie) {
            $listCategorieJson[] = array(
                "id" => $categorie->getId(),
                "libelle" => $categorie->getLibelle(),
                "couleur" => $categorie->getCouleur(),
            );
        }*/

        $listCategorieJson[] = array(
            "id" => "1",
            "libelle" => "placeholder",
            "couleur" => "#4475c4",
        );

        //Liste des evenements
        $listEvenements = $em->getRepository('JardinDenfantProfilJDBundle:Evenement')->findAll();
        $listEvenementsJson = array();
        foreach ($listEvenements as $evenement) {
            $listEvenementsJson[] = array(
                "id" => $evenement->getIde(),
                "categorie" => "placeholder",
                "titre" => $evenement->getNonE(),
               "image" => $evenement -> getImage(),
                "date" => "" . strtotime($evenement->getStart()->format('Y-m-d H:i:s')) . "",
                "description" => $evenement->getApropos(),
                "local" =>$evenement->getAdresse(),
                //"lien" => "event/show/" . $evenement->getId(),
                //"prix" => "15"
            );
        }

        return new JsonResponse(array('listCategories' => $listCategorieJson,"listEvenements" => $listEvenementsJson));
    }

    public function afficherEventsParJardinAction(Request $request)
    {


        $em = $this->getDoctrine()->getManager();


        $user = $this->getUser();
        $id = $user->getId();

        $em = $this->getDoctrine()->getManager();
        $num=$em->getRepository('JardinDenfantProfilJDBundle:ProfilJD')->findOneBy(array('id'=>$id));
        $numauth=$num->getNumauth();

        $ev = $em->getRepository("JardinDenfantProfilJDBundle:Evenement")->findBy(array('numauth'=>$numauth));

        //exit(VarDumper::dump($ev));

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
        $data = array(
            'last_username' => $lastUsername,
            'error' => $error,
            'csrf_token' => $csrfToken,
            'routename' => $routeName,
            "ev" => $ev,



        );


        return $this->render('JardinDenfantProfilJDBundle:Evenement:afficherEventsParJardin.html.twig', $data);
    }

}
