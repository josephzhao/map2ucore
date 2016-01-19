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
class BaseMappingController extends Controller {

    protected $map_class;
    protected $layer_class;
    protected $symbolizedlayer_class;

    public function __construct() {
        $this->map_class = "Map2uCoreBundle:Map";
        $this->layer_class = "Map2uCoreBundle:Layer";
        $this->symbolizedlayer_class = "Map2uCoreBundle:SymbolizedLayer";
    }

    //put your code here
    /**
     * show mapping list page.
     *
     * @Route("/", name="mapping_index")
     * @Method("GET")
     * @Template()
     */
    public function indexAction(Request $request) {
        var_dump($this->map_class);
        $mc = $this->container->hasParameter('map2u.core.map.class');
        var_dump($mc);
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
     * @Route("/createheatmap", name="mapping_createheatmap", options={"expose"=true})
     * @Method("GET")
     * @Template()
     */
    public function createheatmapAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $spatialfile_id = $request->get("spatialfile_id");
        $keyfield = $request->get("keyfield");
        $user = $this->getUser();
        $settings = array();
        $settings['spatialfile_id'] = $spatialfile_id;
        $settings['keyfield'] = $keyfield;
        $conn = $this->getDoctrine()->getConnection();
        $heatmaps = null;
        if ($user && $user != 'anon.') {
            if (isset($spatialfile_id) && strlen($spatialfile_id) === 36) {
                $spatialfiles = $em->createQuery("SELECT u FROM Map2uCoreBundle:SpatialFile u WHERE  u.id ='" . $spatialfile_id . "'")
                        ->getResult();
            } {
                $spatialfiles = $em->createQuery("SELECT u FROM Map2uCoreBundle:SpatialFile u WHERE (u.supportType =3 ) and (u.userId='" . $user->getId() . "' or u.public=true)  order by u.updatedAt DESC")
                        ->getResult();
                $heatmaps = $em->createQuery("SELECT u FROM Map2uCoreBundle:Layer u WHERE (u.type ='heatmap' ) and (u.userId='" . $user->getId() . "' or u.public=true)  order by u.updatedAt DESC")
                        ->getResult();
            }
        } else {
            if (isset($spatialfile_id) && strlen($spatialfile_id) === 36) {

                $spatialfiles = $em->createQuery("SELECT u FROM Map2uCoreBundle:SpatialFile u WHERE  u.id ='" . $spatialfile_id . "'")
                        ->getResult();
            } {

                $spatialfiles = $em->createQuery("SELECT u FROM Map2uCoreBundle:SpatialFile u   order by u.updatedAt DESC")
                        //           $spatialfiles = $em->createQuery("SELECT u FROM Map2uManifoldMapsBundle:SpatialFile u WHERE  (u.supportType =2 ) and u.public=true  order by u.updatedAt DESC")
                        ->getResult();
                $heatmaps = $em->createQuery("SELECT u FROM Map2uCoreBundle:Layer u WHERE u.type ='heatmap'  and  u.public=true  order by u.updatedAt DESC")
                        ->getResult();
            }
        }
        $st_spatialfiles = array();
        foreach ($spatialfiles as $spatialfile) {
            $result = $conn->fetchAll("SELECT ST_GeometryType(the_geom) as type FROM spatial_" . str_replace("-", "_", $spatialfile->getId()));
            if (count($result) > 0 && $result[0] && $result[0]['type'] == 'ST_Point') {

                if ($settings['spatialfile_id'] === null || $settings['spatialfile_id'] === 'null') {
                    $settings['spatialfile_id'] = $spatialfile->getId();
                    $selectedFields = unserialize($spatialfile->getSelectedFields());
                    $settings['keyfield'] = $selectedFields['cbox_loc_count'];
                }
                if (intval($settings['spatialfile_id']) === $spatialfile->getId() && ($settings['keyfield'] === null || $settings['keyfield'] === 'null' )) {
                    $selectedFields = unserialize($spatialfile->getSelectedFields());

                    $settings['keyfield'] = $selectedFields['cbox_loc_count'];
                }
                array_push($st_spatialfiles, $spatialfile);
            }
        }
        $marker_image_types = array_diff(scandir($this->get('kernel')->getRootDir() . '/../web/images/markers'), array('..', '.'));
        return array('heatmaps' => $heatmaps, 'spatialfiles' => $st_spatialfiles, 'marker_image_types' => $marker_image_types, 'settings' => $settings);
    }

    /**
     * show mapping list page.
     *
     * @Route("/userdraw", name="mapping_userdraw", options={"expose"=true})
     * @Method("GET|POST")
     * @Template()
     */
    public function userdrawAction(Request $request) {
        $marker_image_types = array_diff(scandir($this->get('kernel')->getRootDir() . '/../web/images/markers'), array('..', '.'));
        return array("marker_image_types" => $marker_image_types);
    }

    /**
     * show mapping list page.
     *
     * @Route("/settings", name="mapping_settings", options={"expose"=true})
     * @Method("GET|POST")
     * @Template()
     */
    public function settingsAction(Request $request) {
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
