<?php

namespace Loisirs\LoisirsBundle\Controller;

use Loisirs\LoisirsBundle\Entity\Quiz;
use Loisirs\LoisirsBundle\Form\QuizType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Security;

class QuizController extends Controller
{
    public function AjoutQuizAction(request $request)
    {

        $quiz=new Quiz();
        $Form = $this->createForm(QuizType::class, $quiz);
        $Form->handleRequest($request);
        if ($Form->isValid()) {
            $m = $this->getDoctrine()->getManager();
            $m->persist($quiz);
            $m->flush();
            return $this->redirectToRoute('_affiche_quiz');
        }
        return $this->render('LoisirsLoisirsBundle:Quiz:ajout_quiz.html.twig', array(
            'f' => $Form->createView()
        ));
    }


    public function AfficheQuizAction()
    {

        $m=$this->getDoctrine()->getManager();
        $quiz=$m->getRepository('LoisirsLoisirsBundle:Quiz')->findAll();

        return $this->render('LoisirsLoisirsBundle:Quiz:affiche_quiz.html.twig', array(
            'quiz'=>$quiz
        ));


    }

    public function SupprimerQuizAction($id)
    {
        $m=$this->getDoctrine()->getManager();
        $quiz=$m->getRepository('LoisirsLoisirsBundle:Quiz')->find($id);
        $m->remove($quiz);
        $m->flush();
        return  $this->redirectToRoute('_affiche_quiz');

    }
    public function ModifierQuizAction($id,Request $request)
    {
        $m=$this->getDoctrine()->getManager();
        $quiz=$m->getRepository('LoisirsLoisirsBundle:Quiz')->find($id);
        $form=$this->createForm(QuizType::class,$quiz);
        if($form->handleRequest($request)->isValid()) {
            $m->persist($quiz);
            $m->flush();
            return $this->redirectToRoute('_affiche_quiz');

        }
        return $this->render('LoisirsLoisirsBundle:Quiz:modif_quiz.html.twig', array('f'=>$form->createView()));


    }
    public function AfficheClientQuizAction($id,Request $request)
    {

        $score=0;

        $em = $this->getDoctrine()->getManager();
        $quiz = $em->getRepository('LoisirsLoisirsBundle:Quiz')->findBy(array('theme'=>$id));

       if($request->getMethod()=="POST")
        {



            foreach ($quiz as $q){
                $x=$request->get($q->getId());



                if($q->getReponse()==$x)
                {
                    $score++;
                }

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
                'routename'=>$routeName,'quiz'=>$quiz,'res'=>$score
            );


            return $this->render('LoisirsLoisirsBundle:Quiz:afficheclient_quiz.html.twig',$data);

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
            'routename'=>$routeName,'quiz'=>$quiz,'res'=>0
        );

        return $this->render('LoisirsLoisirsBundle:Quiz:afficheclient_quiz.html.twig',$data);




    }
}
