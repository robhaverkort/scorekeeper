<?php

namespace ScorekeeperBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class UserController extends Controller {

    /**
     * @Route("/user", name="user")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function indexAction() {
        $repository = $this->getDoctrine()
                ->getRepository('ScorekeeperBundle:User');
        $users = $repository->findAll();
        return $this->render('ScorekeeperBundle:User:index.html.twig', array('users' => $users));
    }

}
