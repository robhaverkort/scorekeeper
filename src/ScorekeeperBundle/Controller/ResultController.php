<?php

namespace ScorekeeperBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use ScorekeeperBundle\Entity\Result;
use ScorekeeperBundle\Form\Type\ResultType;

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
     * @Route("/result/new", name="result_new")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function newAction(Request $request) {
        $repository = $this->getDoctrine()
                ->getRepository('ScorekeeperBundle:User');
        $users = $repository->findAll();
        $repository = $this->getDoctrine()
                ->getRepository('ScorekeeperBundle:Contest');
        $contests = $repository->findAll();

        $result = new Result();
        $form = $this->createForm(new ResultType(),$result);

        $form->handleRequest($request);
        if ($form->isValid()) {
            
        }
        
        return $this->render('ScorekeeperBundle:Result:new.html.twig', array('users' => $users, 'contests' => $contests, 'form' => $form->createView()));
    }

    /**
     * @Route("/result/edit/{result_id}", name="result_edit")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function editAction($result_id) {
        $repository = $this->getDoctrine()
                ->getRepository('ScorekeeperBundle:User');
        $users = $repository->findAll();
        return $this->render('ScorekeeperBundle:Result:edit.html.twig', array('result_id' => $result_id, 'users' => $users));
    }

    /**
     * @Route("/result/delete/{result_id}", name="result_delete")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function deleteAction($result_id) {
        $em = $this->getDoctrine()->getManager();
        $result = $em->getRepository('ScorekeeperBundle:Result')->find($result_id);
        $contest_id = $result->getContest()->getId();
        $em->remove($result);
        $em->flush();
        return $this->redirectToRoute('contest_view', array('contest_id' => $contest_id));
    }

}
