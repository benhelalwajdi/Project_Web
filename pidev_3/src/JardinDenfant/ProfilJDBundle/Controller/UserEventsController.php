<?php

namespace JardinDenfant\ProfilJDBundle\Controller;

use JardinDenfant\ProfilJDBundle\Entity\UserEvents;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\VarDumper\VarDumper;

class UserEventsController extends Controller
{
    public function inscrirerAction(Request $request,$ide)
    {


        $i = new UserEvents();
        $user = $this->getUser();
        $id = $user->getId();

        //$i->setId(1);
        $i->setUser($user);
        //$i->setEvenement($ide);
            $em =$this->getDoctrine()->getManager();

        $num=$em->getRepository('JardinDenfantProfilJDBundle:Evenement')->findOneBy(array('ide'=>$ide));
        $i->setEvenement($num);
       // exit(VarDumper::dump($i));
        $nbr=$num->getNbrPlaceMax();
        if($this->nombreInscriAction($ide)< $nbr)
            {
                $em->persist($i); //insert dans la bD
                $em->flush(); //execution
                // return $this->redirectToRoute('_succes');
                return $this->render('JardinDenfantProfilJDBundle:UserEvents:inscrirer.html.twig', array(
                    // ...
                ));
            }
        else if ($this->nombreInscriAction($ide)>= $nbr){
               return $this->render('JardinDenfantProfilJDBundle:UserEvents:erreur.html.twig', array(// ...
                ));
            }


    }


    public function nombreInscriAction($ide)
    {
        $em = $this->getDoctrine()->getManager();
        $locationRepo = $em->getRepository('JardinDenfantProfilJDBundle:UserEvents');
        $nb = $locationRepo->getNb($ide);
        return $nb;
    }


    public function AnnulerInscritAction(Request $request,$ide)
    {
        $em =$this->getDoctrine()->getManager();

        $num=$em->getRepository('JardinDenfantProfilJDBundle:Evenement')->findOneBy(array('ide'=>$ide));


        $user = $this->getUser();
        $id = $user->getId();
        $useins=$em->getRepository('JardinDenfantProfilJDBundle:UserEvents')->findevents($id,$ide);
       // $i = new UserEvents();
        //$i=$useins;
        //exit(VarDumper::dump($i));
       // if($useins!=null){
          //  exit(VarDumper::dump('eeee'));

               // $em->remove($useins); //insert dans la bD
              //  $em->flush(); //execution

           // }
        //$i->setId(1);
        //$i->setUser($user);
        //$i->setEvenement($ide);
        //$i->setEvenement($num);
        // exit(VarDumper::dump($i));
        //
        //$nbr=$num->getNbrPlaceMax();



           // $em->remove($); //insert dans la bD
          //  $em->flush(); //execution
            // return $this->redirectToRoute('_succes');
            return $this->redirectToRoute('afficher_e');


        }

    function verifierClickAction (Request $request,$ide)
    {
        $em =$this->getDoctrine()->getManager();

        $num=$em->getRepository('JardinDenfantProfilJDBundle:Evenement')->findOneBy(array('ide'=>$ide));


        $user = $this->getUser();
        $id = $user->getId();
        $useins=$em->getRepository('JardinDenfantProfilJDBundle:UserEvents')->findevents($id,$ide);
        // $i = new UserEvents();
        //$i=$useins;
        //exit(VarDumper::dump($i));
        if($useins=$id){
            exit(VarDumper::dump('eeee'));}


    }




}
