<?php

namespace Map2u\CoreBundle\Controller;

use Sonata\AdminBundle\Controller\CRUDController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

/**
 * Project controller.
 *
 * @Route("/project")
 */
class ProjectController extends CRUDController {

    /**
     * Welcome controller.
     *
     * @Route("/list" , name="project_list")
     * @Method("GET|POST")
     * @Template()
     *    
     */
    public function listAction(Request $request = NULL) {
        $_sonata_admin=array();
        parent::listAction($request);
    }

}
