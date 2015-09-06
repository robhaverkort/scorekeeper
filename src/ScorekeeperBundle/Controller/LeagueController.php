<?php

namespace ScorekeeperBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class LeagueController extends Controller {

    /**
     * @Route("/league", name="league")
     * @Security("has_role('ROLE_USER')")
     */
    public function indexAction() {
        $repository = $this->getDoctrine()
                ->getRepository('ScorekeeperBundle:League');
        $leagues = $repository->findAll();
        return $this->render('ScorekeeperBundle:League:index.html.twig', array('leagues' => $leagues));
    }

    /**
     * @Route("/league/{league_id}", name="league_view")
     * @Security("has_role('ROLE_USER')")
     */
    public function viewAction($league_id) {
        $repository = $this->getDoctrine()
                ->getRepository('ScorekeeperBundle:League');
        $league = $repository->find($league_id);

        $repository = $this->getDoctrine()
                ->getRepository('ScorekeeperBundle:User');
        $users = $repository->findByLeague($league_id);

        $repository = $this->getDoctrine()
                ->getRepository('ScorekeeperBundle:Result');
        foreach ($users as $user) {
            $results[$user->getId()] = $repository->findByLeagueUser($league_id, $user->getId());
            $info[$user->getId()]['sum'] = 0;
            $info[$user->getId()]['min'] = 240;
            $info[$user->getId()]['max'] = 0;
            foreach ($results[$user->getId()] as $result) {
                $info[$user->getId()]['sum'] += $result->getTotal();
                $info[$user->getId()]['min'] = min($info[$user->getId()]['min'], $result->getTotal());
                $info[$user->getId()]['max'] = max($info[$user->getId()]['max'], $result->getTotal());
            }
            $info[$user->getId()]['ave'] = $info[$user->getId()]['sum'] / sizeof($results[$user->getId()]);
        }

        //
        // NEW
        //
        
        $shooters = array();

        $repository = $this->getDoctrine()->getRepository('ScorekeeperBundle:User');
        $users = $repository->findByLeague($league_id);

        $repository = $this->getDoctrine()->getRepository('ScorekeeperBundle:Result');
        foreach ($users as $user) {
            $s = array();
            $s['user'] = $user;
            $s['results'] = $repository->findByLeagueUser($league_id, $user->getId());

            $s['nocount'] = array();
            if (sizeof($s['results']) > 20) {
                foreach ($s['results'] as $key => $result) {
                    $tmp[$key] = $result->getTotal();
                }
                arsort($tmp);
                foreach (array_slice($tmp, 20, NULL, TRUE) as $key => $value)
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
            $s['ave'] = $s['sum'] / sizeof($s['results']);

            $shooters[] = $s;
        }

        usort($shooters, function($a, $b) {
            return $b['sum'] - $a['sum'];
        });

        return $this->render(
                        'ScorekeeperBundle:League:view.html.twig'
                        , array('league' => $league, 'users' => $users, 'results' => $results, 'info' => $info, 'shooters' => $shooters)
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
