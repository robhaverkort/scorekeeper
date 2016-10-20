<?php

namespace ScorekeeperBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class LeagueController extends Controller {

    /**
     * @Route("/league", name="league")
     */
    public function indexAction() {
        $repository = $this->getDoctrine()
                ->getRepository('ScorekeeperBundle:League');
        $leagues = $repository->findAll();
        return $this->render('ScorekeeperBundle:League:index.html.twig', array('leagues' => $leagues));
    }

    /**
     * @Route("/league/{league_id}", name="league_view")
     */
    public function viewAction($league_id) {
        $repository = $this->getDoctrine()
                ->getRepository('ScorekeeperBundle:League');
        $league = $repository->find($league_id);

        $shooters = array();

        $repository = $this->getDoctrine()->getRepository('ScorekeeperBundle:User');
        $users = $repository->findByLeague($league_id);

        $repository = $this->getDoctrine()->getRepository('ScorekeeperBundle:Result');
        foreach ($users as $user) {
            $s = array();
            $s['user'] = $user;
            $s['results'] = $repository->findByLeagueUser($league_id, $user->getId());

            $s['nocount'] = array();
            if (sizeof($s['results']) > $league->getCountContests() ) {
                $tmp = array();
                foreach ($s['results'] as $key => $result) {
                    if ($key < $league->getMaxContests())
                        $tmp[$key] = $result->getTotal();
                }
                arsort($tmp);
                foreach (array_slice($tmp, $league->getCountContests(), NULL, TRUE) as $key => $value)
                    $s['nocount'][] = $key;
            }
            // exclude if more than 25 turns
            if (sizeof($s['results']) > $league->getMaxContests()) {
                foreach (array_slice($s['results'], $league->getMaxContests(), NULL, TRUE) as $key => $value)
                    $s['nocount'][] = $key;
            }

            $s['sum'] = 0;
            $s['min'] = 240;
            $s['max'] = 0;

            foreach ($s['results'] as $key => $result) {
                if (!in_array($key, $s['nocount'])) {
                    $s['sum'] += $result->getTotal();
                    $s['min'] = min($s['min'], $result->getTotal());
                    $s['max'] = max($s['max'], $result->getTotal());
                }
            }
            $s['ave'] = $s['sum'] / (sizeof($s['results']) - sizeof($s['nocount']));

            $shooters[] = $s;
        }

        usort($shooters, function($a, $b) {
            return $b['sum'] - $a['sum'];
        });

        return $this->render(
                        'ScorekeeperBundle:League:view.html.twig'
                        , array('league' => $league, 'shooters' => $shooters)
        );
    }

    /**
     * @Route("/league/email/{league_id}", name="league_email")
     * @Security("has_role('ROLE_USER')")
     */
    public function emailAction($league_id) {

        $mailer = $this->get('mailer');
        $message = $mailer->createMessage()
                ->setSubject('Stand Competitie')
                ->setFrom('rob.haverkort@ziggo.nl')
                ->setTo('rob.haverkort@ziggo.nl')
                ->setBody(
                "TESTMAIL"
                //$this->renderView(
                //        'ScorekeeperBundle:League:view.html.twig'
                //        , array('league' => $league, 'users' => $users, 'results' => $results, 'info' => $info)
                //), 'text/html'
                )
        /*
         * If you also want to include a plaintext version of the message
          ->addPart(
          $this->renderView(
          'Emails/registration.txt.twig',
          array('name' => $name)
          ),
          'text/plain'
          )
         */
        ;
        $mailer->send($message);
        //return $this->render('ScorekeeperBundle:League:emailSuccess.html.twig');
        return $this->redirectToRoute('homepage');
    }

}
