<?php

namespace ScorekeeperBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class ResultController extends Controller {

    /**
     * @Route("/result", name="result")
     * @Security("has_role('ROLE_USER')")
     */
    public function indexAction() {
        $repository = $this->getDoctrine()
                ->getRepository('ScorekeeperBundle:Result');
        $results = $repository->findAll();

        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery(
                'SELECT r
                    FROM ScorekeeperBundle:Result r
                    JOIN r.user u
                    JOIN r.contest c
                    JOIN c.league l
                    ORDER BY c.date DESC'
        );
        $results = $query->getResult();

        return $this->render('ScorekeeperBundle:Result:index.html.twig', array('results' => $results));
    }

    /**
     * @Route("/result/new", name="newresult")
     * @Security("has_role('ROLE_USER')")
     */
    public function newAction() {
        $repository = $this->getDoctrine()
                ->getRepository('ScorekeeperBundle:User');
        $users = $repository->findAll();
        $repository = $this->getDoctrine()
                ->getRepository('ScorekeeperBundle:Contest');
        $contests = $repository->findAll();
        return $this->render('ScorekeeperBundle:Result:new.html.twig',array('users'=>$users,'contests'=>$contests));
    }

}
