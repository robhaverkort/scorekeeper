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
     * @Route("/result/new/{contest_id}", name="result_new")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function newAction(Request $request,$contest_id) {
        $repository = $this->getDoctrine()
                ->getRepository('ScorekeeperBundle:User');
        $users = $repository->findAll();
        $repository = $this->getDoctrine()
                ->getRepository('ScorekeeperBundle:Contest');
        $contests = $repository->findAll();
        $contest = $repository->find($contest_id);

        $result = new Result();
        $result->setContest($contest);
        $result->setDetails("");
        $form = $this->createForm(new ResultType(), $result, array(
            'action' => $this->generateUrl('result_new',array('contest_id'=>$contest_id)),
            'method' => 'GET',
        ));

        $form->handleRequest($request);
        $debug = serialize($form->getData());
        $debug = $form->getData();
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($result);
            $em->flush();
            //$this->addFlash(
            //        'notice', 'Your changes were saved!'
            //);
            return $this->redirectToRoute('contest_view',array('contest_id'=>$contest_id));
        } else {
            //$this->addFlash(
            //        'notice', 'No changes!'
            //);
        }
        //return NULL;
        return $this->render('ScorekeeperBundle:Result:new.html.twig', array('users' => $users, 'contests' => $contests, 'form' => $form->createView(), 'debug' => $debug));
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
