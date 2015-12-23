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
 * @Route("/mapping")
 */

/**
 * Description of WelcomeController
 *
 * @author josephzhao
 */
class MappingController extends Controller {

    //put your code here
    /**
     * show mapping list page.
     *
     * @Route("/", name="mapping_index")
     * @Method("GET")
     * @Template()
     */
    public function indexAction(Request $request) {
        return array();
    }

    /**
     * show mapping list page.
     *
     * @Route("/map", name="mapping_map")
     * @Method("GET")
     * @Template()
     */
    public function mapAction(Request $request) {
        return array();
    }

    /**
     * show mapping list page.
     *
     * @Route("/spatialfile_upload", name="mapping_spatialfile_upload", options={"expose"=true})
     * @Method("GET")
     * @Template()
     */
    public function spatialfile_uploadAction(Request $request) {
        return array();
    }

    /**
     * show mapping list page.
     *
     * @Route("/sidebar", name="mapping_sidebar", options={"expose"=true})
     * @Method("GET")
     * @Template()
     */
    public function sidebarAction(Request $request) {
        return array();
    }

    /**
     * Welcome controller.
     *
     * @Route("/osm_legend" , name="mapping_osm_legend", options={"expose"=true})
     */
    public function osm_legendAction() {
        return $this->render('Map2uCoreBundle:Mapping:osm_legend.html.twig');
    }

    /**
     * Welcome controller.
     *
     * @Route("/uploadspatialfile" , name="mapping_uploadspatialfile", options={"expose"=true})
     * @Method({"GET"})
     * @Template()
     */
    public function uploadspatialfileAction() {

        $user = $this->getUser();
        if (!isset($user) || empty($user)) {
            return new Response(\json_encode(array('success' => false, 'type' => '', 'message' => 'Only logged in user can show shapefiles list')));
        }
        return array();
    }

}
