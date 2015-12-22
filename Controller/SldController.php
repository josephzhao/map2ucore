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
 * SLD controller.
 *
 * @Route("/sld")
 */

/**
 * Description of WelcomeController
 *
 * @author josephzhao
 */
class SldController extends Controller {

    //put your code here
    /**
     * show sld list page.
     *
     * @Route("/", name="sld_index", options={"expose"=true})
     * @Method("GET")
     * @Template()
     */
    public function indexAction(Request $request) {
        return array();
    }

    //put your code here
    /**
     * show sld list page.
     *
     * @Route("/save", name="sld_save", options={"expose"=true})
     * @Method("POST")
     * @Template()
     */
    public function saveAction(Request $request) {
        $attributes = $request->get("attributes");
        $this->writeToSLD($attributes);
        return array();
    }

    private function writeToSLD($attributes) {
        
    }

}
