<?php

namespace Map2u\CoreBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Map2u\CoreBundle\Entity\SpatialFile;
use Map2u\CoreBundle\Entity\UserDrawGeometries;

/**
 * Welcome controller.
 *
 * @Route("/map")
 */
class MapController extends Controller {

    /**
     * show mapping list page.
     *
     * @Route("/layerlist", name="map_layerlist", options={"expose"=true})
     * @Method("GET")
     * @Template()
     */
    public function layerlistAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $map_id = $request->get("map_id");
        $map = null;
      
        $serialized_map = null;
        $serialized_layers = null;
        if ($map_id !== null && strlen(trim($map_id)) === 36) {
            $map = $em->getRepository($this->getParameter("map2u.core.map.class"))->find($map_id);
        }
        
       $layerCategories= $em->createQuery(sprintf('SELECT c FROM %s c WHERE c.parent is null and (c.user=:user or c.public=true)', $this->getParameter("map2u.core.layercategory.class")))
                    ->setParameter('user', $user)
                    ->execute();
//       $maps= $em->createQuery(sprintf('SELECT c FROM %s c WHERE  (c.user=:user or c.public=true)', $this->getParameter("map2u.core.map.class")))
//                    ->setParameter('user', $this->user)
//                    ->execute();
 
       if ($map === null) {
            $map = $em->getRepository($this->getParameter("map2u.core.map.class"))->findOneBy(array("public" => true, "shared" => true));
        }
        if ($map) {
            $serialized_map = serialize($map);
        } else {
            $layers = $em->getRepository($this->getParameter("map2u.core.symbolizedlayer.class"))->findBy(array("public" => true,'layerCategory'=>null));
            if ($layers !== null && count($layers) > 0) {
                $serialized_layers = serialize($layers);
            }
        }
        return  array("success" => true, "layerCategories" => $layerCategories, "map_data" => $serialized_map, "serialized_layer_data" => $serialized_layers);
  //      return new JsonResponse(array("success" => true, "layerCategories" => serialize($layerCategories), "map_data" => $serialized_map, "serialized_layer_data" => $serialized_layers));
    }

    /**
     * show mapping list page.
     *
     * @Route("/maplist", name="map_maplist", options={"expose"=true})
     * @Method("GET")
     * @Template()
     */
    public function maplistAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $map_id = $request->get("map_id");
        $map = null;
        $serialized_map = null;
        $serialized_layers = null;
        if ($map_id !== null && strlen(trim($map_id)) === 36) {
            $map = $em->getRepository($this->getParameter("map2u.core.map.class"))->find($map_id);
        }
        if ($map === null) {
            $map = $em->getRepository($this->getParameter("map2u.core.map.class"))->findOneBy(array("public" => true, "shared" => true));
        }
        if ($map) {
            $serialized_map = serialize($map);
        } else {
            $layers = $em->getRepository($this->getParameter("map2u.core.symbolizedlayer.class"))->findBy(array("public" => true));
            if ($layers !== null && count($layers) > 0) {
                $serialized_layers = serialize($layers);
            }
        }
        return new JsonResponse(array("success" => true, "map_data" => $serialized_map, "layer_data" => $serialized_layers));
    }

}
