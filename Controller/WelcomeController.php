<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Map2u\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

/**
 * Welcome controller.
 *
 * @Route("/")
 */

/**
 * Description of WelcomeController
 *
 * @author josephzhao
 */
class WelcomeController extends Controller {

    //put your code here
    /**
     * show welcome page.
     *
     * @Route("/", name="welcome_index")
     * @Method("GET")
     * @Template()
     */
    public function indexAction(Request $request) {
        return array();
    }

}
