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

        return $this->render(
                        'ScorekeeperBundle:League:view.html.twig'
                        , array('league' => $league, 'users' => $users, 'results' => $results, 'info' => $info)
        );
    }

    /**
     * @Route("/league/email/{league_id}", name="league_email")
     * @Security("has_role('ROLE_USER')")
     */
    public function emailAction($league_id) {
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
            foreach ($results[$user->getId()] as $result) {
                $info[$user->getId()]['sum'] += $result->getTotal();
            }
            $info[$user->getId()]['ave'] = $info[$user->getId()]['sum'] / sizeof($results[$user->getId()]);
        }

        $mailer = $this->get('mailer');
        $message = $mailer->createMessage()
                ->setSubject('Stand Competitie')
                ->setFrom('rob.haverkort@ziggo.nl')
                ->setTo('rob.haverkort@ziggo.nl')
                ->setBody(
                $this->renderView(
                        'ScorekeeperBundle:League:view.html.twig'
                        , array('league' => $league, 'users' => $users, 'results' => $results, 'info' => $info)
                ), 'text/html'
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
        return $this->render('ScorekeeperBundle:League:emailSuccess.html.twig');
        //return $this->redirectToRoute('homepage');
    }

}
