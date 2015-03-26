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
            foreach ($results[$user->getId()] as $result) {
                $info[$user->getId()]['sum'] += $result->getTotal();
            }
            $info[$user->getId()]['ave'] = $info[$user->getId()]['sum'] / sizeof($results[$user->getId()]);
        }

        return $this->render(
                        'ScorekeeperBundle:League:view.html.twig'
                        , array('league' => $league, 'users' => $users, 'results' => $results, 'info' => $info)
        );
    }

}
