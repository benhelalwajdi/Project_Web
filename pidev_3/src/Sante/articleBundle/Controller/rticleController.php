<?php

namespace Sante\articleBundle\Controller;

use Sante\articleBundle\Entity\article;
use Sante\articleBundle\Entity\likearticle;
use Sante\articleBundle\Entity\notifarticle;
use Sante\articleBundle\Form\article2Type;
use Sante\articleBundle\Form\articleType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Component\Validator\Tests\Fixtures\ToString;
use Symfony\Component\Templating\PhpEngine;
use Knp\Bundle\SnappyBundle\Snappy\Response\PdfResponse;

class rticleController extends Controller
{
    public function listerticleAction(Request $request)
    {

        $em=$this->getDoctrine()->getManager();
        $articless = $em->getRepository('SantearticleBundle:article')->articletrié("accepté");
        if($request->getMethod()=="POST") {
            $articless = $em->getRepository('SantearticleBundle:article')->findarticle($request->get('mot'),"accepté");

        }
        /**
         * @var $paginator \Knp\Component\Pager\Paginator
         */
        $paginator=$this->get('knp_paginator');
        $articles=$paginator->paginate(
            $articless,
            $request->query->getInt('page',1),
            $request->query->getInt('limit',3)
        );
        dump(get_class($paginator));
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
            'routename'=>$routeName,"articles"=>$articles
        );
        return $this->render('SantearticleBundle:rticle:listerticle.html.twig', $data
        );
    }
    public function DetailArticleAction(Request $request,$idarticle)
    {
        $m=$this->getDoctrine()->getManager();
        $article = $m->getRepository('SantearticleBundle:article')->findBy(array('idarticle'=>$idarticle));
        $us = $this->get('security.token_storage')->getToken()->getUser();
        $likeetat=$m->getRepository('SantearticleBundle:likearticle')->findOneBy(array('idarticle'=>$idarticle,'idliker'=>$us));
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
            'routename'=>$routeName,'m' => $article,'etat'=>$likeetat
        );
        return $this->render('SantearticleBundle:rticle:DetailArticle.html.twig', $data
        // ...
        );
    }

    public function LikeArticleNullAction(Request $request,$idarticle,$id)
    {
        $m=$this->getDoctrine()->getManager();
        $article = $m->getRepository('SantearticleBundle:article')->findOneBy(array('idarticle'=>$idarticle));
        $nb=$article->getNblike();
        $article->setNblike($nb+1);
        $m->persist($article);
        $m->flush();
        $likearticle = new likearticle();
        $likearticle->setIdarticle($idarticle);
        $likearticle->setIdliker($id);
        $likearticle->setLikeetat(1);
        $m->persist($likearticle);
        $m->flush();
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
            'routename'=>$routeName,'m' => $article,'idarticle'=>$idarticle
        );
        return $this->redirectToRoute('DetailArticle',$data);

    }
    public function LikeArticleAction(Request $request,$idarticle,$id)
    {
        $m=$this->getDoctrine()->getManager();
        $article = $m->getRepository('SantearticleBundle:article')->findOneBy(array('idarticle'=>$idarticle));
        $nb=$article->getNblike();
        $article->setNblike($nb+1);
        $m->persist($article);
        $m->flush();
        $likearticle = $m->getRepository('SantearticleBundle:likearticle')->UpdateEtat(1,$idarticle,$id);
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
            'routename'=>$routeName,'idarticle' => $idarticle
        );
        return $this->redirectToRoute('DetailArticle',$data);

    }
    public function unLikeArticleAction(Request $request,$idarticle,$id)
    {
        $m=$this->getDoctrine()->getManager();
        $article = $m->getRepository('SantearticleBundle:article')->findOneBy(array('idarticle'=>$idarticle));
        $nb=$article->getNblike();
        $article->setNblike($nb-1);
        $m->persist($article);
        $m->flush();
        $likearticle = $m->getRepository('SantearticleBundle:likearticle')->UpdateEtat(0,$idarticle,$id);
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
            'routename'=>$routeName,'idarticle' => $idarticle
        );
        return $this->redirectToRoute('DetailArticle',$data);

    }


    public function DetailArticlePersonnelAction(Request $request,$idarticle)
    {
        $m=$this->getDoctrine()->getManager();
        $article = $m->getRepository('SantearticleBundle:article')->findBy(array('idarticle'=>$idarticle));
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
            'routename'=>$routeName,'m' => $article,'idarticle'=>$idarticle
        );
        return $this->render('SantearticleBundle:rticle:DetailArticlePersonnel.html.twig', $data
        // ...
        );
    }
    public function listerticlePersonnelAction(Request $request,$id)
    {
        $em=$this->getDoctrine()->getManager();
        $articless = $em->getRepository('SantearticleBundle:article')->articletriépersonnel($id);
        $nb = $em->getRepository('SantearticleBundle:article')->CalcularticleTotal($id);
        $nbaccepté = $em->getRepository('SantearticleBundle:article')->Calcularticleaccepté($id,"accepté");
        $nbrefusé = $em->getRepository('SantearticleBundle:article')->Calcularticleaccepté($id,"refusé");
        $nbencours = $em->getRepository('SantearticleBundle:article')->Calcularticleaccepté($id,"en cours");
        if($request->getMethod()=="POST") {
            $articless = $em->getRepository('SantearticleBundle:article')->findarticlepersonnel($request->get('mot'),$id);

        }
        /**
         * @var $paginator \Knp\Component\Pager\Paginator
         */
        $paginator=$this->get('knp_paginator');
        $articles=$paginator->paginate(
            $articless,
            $request->query->getInt('page',1),
            $request->query->getInt('limit',3)
        );
        dump(get_class($paginator));
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
            'routename'=>$routeName,"articles"=>$articles,'nb'=>$nb,'nbaccepté'=>$nbaccepté,'nbrefusé'=>$nbrefusé,'nbencours'=>$nbencours
        );
        return $this->render('SantearticleBundle:rticle:listerticlePersonnel.html.twig',$data
        );
    }
    public function modifierarticleAction(Request $request,$idarticle,$id)
    {

        $em = $this->getDoctrine()->getManager();
        $mark=$em->getRepository('SantearticleBundle:article')->find($idarticle);
        $form=$this->createForm(article2Type::class,$mark,array('method' => 'PUT'));
        if ($form->handleRequest($request)->isSubmitted())
        {$mark->setEtat("en cours");
            $em->persist($mark);
            $em->flush();
            $this->get('session')->getFlashBag()->add(
                'success',
                "Votre article a été bien modifié! Attedez la validation de l'administrateur."
            );
            return $this->redirectToRoute('listerticlepersonnel',array('id' => $id));
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
            'routename'=>$routeName, 'f'=>$form->createView()
        );
        return $this->render('SantearticleBundle:rticle:ajouterarticle.html.twig', $data );

    }

    public function ajouterarticleAction(Request $request,$id)
    {
        $article= new article();
        $form = $this->createForm(articleType::class,$article,array('method' => 'PUT'));

        if($form->handleRequest($request)->isValid())
        {$em = $this->getDoctrine()->getManager();
            $article->setNblike(0);
            $article->setEtat("en cours");
            $Dd=new \DateTime('now');
            $result = $Dd->format('Y-m-d H:i:s');

            $article->setDatepublicaton($result);
            $article->setIdauteur($id);
            $em->persist($article); // insert into table
            $em->flush(); //executer
            $this->get('session')->getFlashBag()->add(
                'success',
                'Votre article a été ajouté avec succès! Attedez la validation de l\'administrateur.'
            );

            return $this->redirectToRoute('listerticlepersonnel',array('id' => $id));

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
            'routename'=>$routeName,'f'=>$form->createView(),'val'=>$id
        );
        return $this->render('SantearticleBundle:rticle:ajouterarticle.html.twig',$data);
    }

    public function supprimerarticleAction(Request $request,$idarticle,$id)
    {
        $em = $this->getDoctrine()->getManager();
        $mark=$em->getRepository('SantearticleBundle:article')->find($idarticle);
        $em->remove($mark);
        $em->flush();
        $this->get('session')->getFlashBag()->add(
            'success',
            'Votre article a été supprimé avec succès !'
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
        $data=array(
            'last_username' => $lastUsername,
            'error' => $error,
            'csrf_token' => $csrfToken,
            'routename'=>$routeName,'id' => $id
        );
        return $this->redirectToRoute('listerticlepersonnel',$data);
    }

    public function listevaliderarticlearticleAction(Request $request)
    {
        $em=$this->getDoctrine()->getManager();
        $articless = $em->getRepository('SantearticleBundle:article')->findBy(array('etat'=>"en cours"));
        /**
         * @var $paginator \Knp\Component\Pager\Paginator
         */
        $paginator=$this->get('knp_paginator');
        $articles=$paginator->paginate(
            $articless,
            $request->query->getInt('page',1),
            $request->query->getInt('limit',20)
        );
        dump(get_class($paginator));
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
        return $this->render('SantearticleBundle:admin:articleValidation.html.twig', array($data,"articles"=>$articles
        ));

    }
    public function DetailvaliderarticleAction(Request $request,$idarticle)
    {
        $m=$this->getDoctrine()->getManager();
        $article = $m->getRepository('SantearticleBundle:article')->findBy(array('idarticle'=>$idarticle));
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
            'routename'=>$routeName,'m' => $article
        );
        return $this->render('SantearticleBundle:rticle:DetailArticleValidation.html.twig', $data
        // ...
        );
    }

    public function AccpeterarticleAction(Request $request,$idarticle)
    {

        $em=$this->getDoctrine()->getManager();
        $em->getRepository('SantearticleBundle:article')->UpdateEtat("accepté",$idarticle);
        $a = $em->getRepository('SantearticleBundle:article')->FindOneBy(array('idarticle'=>$idarticle));
        $notif= new notifarticle();
        $notif->setTitre($a->getTitre());
        $notif->setEtat($a->getEtat());
        $notif->setEtatnotif(0);
        $notif->setIdmedecin($a->getIdauteur());
        $em->persist($notif); // insert into table
        $em->flush(); //executer
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
        return $this->redirectToRoute('listearticleavalider',$data);
    }
    public function RefuserarticleAction($idarticle,Request $request)
    {

        $em=$this->getDoctrine()->getManager();
        $em->getRepository('SantearticleBundle:article')->UpdateEtat("Refusé",$idarticle);
        $a = $em->getRepository('SantearticleBundle:article')->FindOneBy(array('idarticle'=>$idarticle));
        $notif= new notifarticle();
        $notif->setTitre($a->getTitre());
        $notif->setEtat($a->getEtat());
        $notif->setEtatnotif(0);
        $notif->setIdmedecin($a->getIdauteur());
        $em->persist($notif); // insert into table
        $em->flush(); //executer
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
        return $this->redirectToRoute('listearticleavalider',$data);
    }

}
