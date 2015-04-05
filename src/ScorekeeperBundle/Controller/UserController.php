<?php

namespace ScorekeeperBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;


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

    /**
     * @Route("/user/{user_id}", name="user_view")
     * @Security("has_role('ROLE_USER')")
     * XXX@Security("is_granted('user_view',user)")
     */
    public function viewAction($user_id) {
        $repository = $this->getDoctrine()
                ->getRepository('ScorekeeperBundle:User');
        $user = $repository->find($user_id);

        if (false === $this->get('security.authorization_checker')->isGranted('view', $user)) {
            throw new AccessDeniedException('Unauthorised access!');
        }        
        
        return $this->render('ScorekeeperBundle:User:view.html.twig', array('user' => $user));
    }

}
