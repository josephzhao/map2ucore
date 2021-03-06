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
 * @Route("/datamarket")
 */
class DataMarketController extends Controller {

    /**
     * show mapping list page.
     *
     * @Route("/", name="datamarket_index", options={"expose"=true})
     * @Method("GET")
     * @Template()
     */
    public function indexAction(Request $request) {
               
        return array();
    }

}
