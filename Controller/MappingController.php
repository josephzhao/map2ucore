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
use Symfony\Component\HttpFoundation\Response;
use Map2u\CoreBundle\Controller\BaseMappingController;

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
class MappingController extends BaseMappingController {

    protected $map_class;
    protected $layer_class;
    protected $symbolizedlayer_class;

    public function __construct() {
        parent::__construct();
    }

    /**
     * show mapping list page.
     *
     * @Route("/spatialdataset", name="mapping_spatialdataset", options={"expose"=true})
     * @Method("GET")
     * @Template()
     */
    public function spatialdatasetAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        if ($user) {
            $spatialfiles = $em->createQuery("SELECT u FROM Map2uCoreBundle:SpatialFile u WHERE  (u.userId='" . $user->getId() . "' or u.public=true)  order by u.updatedAt DESC")
                    ->getResult();
        } else {
            $spatialfiles = $em->createQuery("SELECT u FROM Map2uCoreBundle:SpatialFile u WHERE u.public=true order by u.updatedAt DESC")
                    ->getResult();
        }
        return array('spatialfiles' => $spatialfiles);
    }

}
