<?php

namespace Map2u\CoreBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use \TCPDF;

/**
 * Map2u Core Default controller.
 *
 * @Route("/")
 */
class DefaultController extends Controller {

    /**
     * show mapping list page.
     *
     * @Route("/left_sidebar", name="default_left_sidebar", options={"expose"=true})
     * @Method("GET")
     * @Template()
     */
    public function left_sidebarAction(Request $request) {
        $routing_index = $request->get("routing_index");
        $em = $this->getDoctrine()->getManager();
        $sidebarmenus = array();
        $sidebarmenu = $em->getRepository("Map2uCoreBundle:SidebarMenu")->findOneBy(array("routing" => $routing_index),array('position'=>'DESC'));
        if ($sidebarmenu) {
            $sidebarmenus = $sidebarmenu->getChildren();
        }
        return array("routing_index" => $routing_index, "sidebarmenus" => $sidebarmenus);
    }

}
