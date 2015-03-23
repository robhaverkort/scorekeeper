<?php

namespace ScorekeeperBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class ContestController extends Controller {

    /**
     * @Route("/contest", name="contest")
     * @Security("has_role('ROLE_USER')")
     */
    public function indexAction() {
        $repository = $this->getDoctrine()
                ->getRepository('ScorekeeperBundle:Contest');
        $contests = $repository->findAll();
        return $this->render('ScorekeeperBundle:Contest:index.html.twig', array('contests' => $contests));
    }

    /**
     * @Route("/contest/{id}", name="contestdetail")
     * @Security("has_role('ROLE_USER')")
     */
    public function viewAction($id) {
        $repository = $this->getDoctrine()
                ->getRepository('ScorekeeperBundle:Contest');
        $contests = $repository->findAll();
        $contest = $repository->find($id);

        $repository = $this->getDoctrine()
                ->getRepository('ScorekeeperBundle:User');
        $users = $repository->findByContest($id);

        $results=array();
        $repository = $this->getDoctrine()
                ->getRepository('ScorekeeperBundle:Result');
        foreach( $users as $user ){
            $results[$user->getId()][]=$repository->findBy(array('user'=>$user->getId(),'contest'=>$id));
        }
        $results=array();
        $results = $repository->findByContest($id);
        return $this->render('ScorekeeperBundle:Contest:view.html.twig', array('contests'=>$contests, 'contest' => $contest,'users'=>$users,'results'=>$results));
    }

}
