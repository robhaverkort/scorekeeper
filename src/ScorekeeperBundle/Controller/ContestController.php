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
     * @Route("/contest/{contest_id}", name="contest_view")
     * @Security("has_role('ROLE_USER')")
     */
    public function viewAction($contest_id) {
        $repository = $this->getDoctrine()
                ->getRepository('ScorekeeperBundle:Contest');
        $contests = $repository->findAll();
        $contest = $repository->find($contest_id);

        $repository = $this->getDoctrine()
                ->getRepository('ScorekeeperBundle:User');
        $users = $repository->findByContest($contest_id);

        $results=array();
        $repository = $this->getDoctrine()
                ->getRepository('ScorekeeperBundle:Result');
        foreach( $users as $user ){
            $results[$user->getId()][]=$repository->findBy(array('user'=>$user->getId(),'contest'=>$contest_id));
        }
        $results=array();
        $results = $repository->findByContest($contest_id);
        return $this->render('ScorekeeperBundle:Contest:view.html.twig', array('contests'=>$contests, 'contest' => $contest,'users'=>$users,'results'=>$results));
    }

}
