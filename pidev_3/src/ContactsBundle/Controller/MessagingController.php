<?php

namespace ContactsBundle\Controller;

use ContactsBundle\Form\messageForm;
use ContactsBundle\Form\newmessage;
use Doctrine\ORM\Query;
use FOS\MessageBundle\Deleter;
use FOS\MessageBundle\Model\ParticipantInterface;
use FOS\MessageBundle\Provider\ProviderInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Serializer\Serializer;

class MessagingController extends Controller implements ContainerAwareInterface
{
    /**
     * @var ContainerInterface
     */
    protected $container;



    /**
     * Displays a thread
     *
     * @param string $threadId the thread id
     *
     * @return Response
     */
    public function threadAction(Request $request)
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
        $id = $request->get('id');
        $recipient = $em->getRepository('UserBundle:User')->findOneBy(array('id' => $id));
        $threadid = $this->getthreadid($id);
        $data = array();
        if ($threadid != -1) {
            $thread = $this->getProvider()->getThread($threadid);
            $allthreads = array();
            $inboxthreads = array();
            $threads_sent = $this->getProvider()->getSentThreads();
            $threads_recieved = $this->getProvider()->getInboxThreads();
            foreach ($threads_sent as $th1) {
                array_push($allthreads, $th1->getId());
            }
            foreach ($threads_recieved as $th2) {
                array_push($allthreads, $th2->getId());
            }
            $threadsids = array_unique($allthreads);

            foreach ($threadsids as $threadid) {
                array_push($inboxthreads, $this->getProvider()->getThread($threadid));
            };

            return $this->render("@Contacts/Chat/conversation.html.twig", array('inbox' => $inboxthreads, 'thread' => $thread, 'us' => $this->getUser(), 'reciepent' => $recipient, 'last_username' => $lastUsername,
                'error' => $error,
                'csrf_token' => $csrfToken,
                'routename'=>$routeName));
        } else {
            return $this->render("@Contacts/Chat/conversation.html.twig", array('inbox' => null, 'thread' => null, 'us' => $this->getUser(), 'reciepent' => $recipient, 'last_username' => $lastUsername,
                'error' => $error,
                'csrf_token' => $csrfToken,
                'routename'=>$routeName));
        }
            }


    /**
     * Create a new message thread.
     *
     * @return Response
     */
    public function sendAction(Request $request)
    {

        date_default_timezone_set('Africa/Tunis');
        $em = $this->getDoctrine()->getManager();
        $id = $request->get('id');
        $recipient = $em->getRepository('UserBundle:User')->findOneBy(array('id' => $id));
        $threadid = $this->getthreadid($id);
        if ($request->getMethod() == 'POST') {
            $body = $request->get('body');
            if ($threadid == -1) {
                $threadBuilder = $this->get('fos_message.composer')->newThread();
                $threadBuilder
                    ->addRecipient($recipient)// Retrieved from your backend, your user manager or ...
                    ->setSubject('Discussion')//A NE PAS CHANGER
                    ->setSender($this->getUser())
                    ->setBody($body);

                $sender = $this->get('fos_message.sender');
                $sender->send($threadBuilder->getMessage());

                } else if ($threadid > 0) {
                $thread = $this->getProvider()->getThread($threadid);
                $threadBuilder = $this->get('fos_message.composer')->reply($thread);
                $threadBuilder
                    ->setBody($body)
                    ->setSender($this->getUser());
                $sender = $this->get('fos_message.sender');
                $sender->send($threadBuilder->getMessage());
            }

        }
        $referer = $request->headers->get('referer');
        if ($referer == NULL) {
            $url = $this->router->generate('fallback_url');
        } else {
            $url = $referer;
        }
        return $this->redirect($url);

    }




    /**
     * Gets the provider service.
     *
     * @return ProviderInterface
     */
    protected function getProvider()
    {
        return $this->container->get('fos_message.provider');
    }

    /**
     * {@inheritdoc}
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function getthreadid($id_reciepent)
    {
        $em = $this->getDoctrine()->getManager();
        $thread1 = $em->getRepository('bsitterBundle:DiscussionMetadata')->findBy(array('participant' => $this->getUser()->getId()));
        $thread2 = $em->getRepository('bsitterBundle:DiscussionMetadata')->findBy(array('participant' => $id_reciepent));
        $thread1ids = array();
        $thread2ids = array();
        foreach ($thread1 as $th) {
            array_push($thread1ids, $th->getThread()->getId());
        }
        foreach ($thread2 as $th) {
            array_push($thread2ids, $th->getThread()->getId());
        }
        $threadkifkif = array_intersect($thread1ids, $thread2ids);
        if (!empty($threadkifkif)) { //found a thread (discussion)
            $keys = array_keys($threadkifkif);
            return $threadkifkif[$keys[0]];
        } else { // thread not found (no discussion between two users)
            return (-1);
        }

    }




}