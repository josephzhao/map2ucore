<?php

namespace Map2u\CoreBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
//use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
//use Map2u\CoreBundle\Entity\UploadfileLayer;
use Map2u\CoreBundle\Entity\UserDrawGeometries;

/**
 * Welcome controller.
 *
 * @Route("/draw")
 */
class DrawController extends Controller {

    /**
     * get feature extend.
     * params: ogc_fid and userboundary_id
     * @Route("/polyline", name="draw_polyline", options={"expose"=true})
     * @Method("GET|POST")
     * @Template()
     */
    public function polylineAction(Request $request) {
      
        $index = $request->get('index');
        $id = $request->get('id');
        $name = $request->get('name');
        $radius = $request->get('radius');
        $em = $this->getDoctrine()->getManager();
        $userdrawlayers = $em->getRepository('Map2uCoreBundle:UserDrawLayer')->findAll();
        if (isset($id) && $id > 0) {
            $usergeometries = $em->getRepository('ApplicationMap2uCoreBundle:UserDrawGeometries')->findOneBy(array("id" => $id));
            $title = "Update Polyline Geometry Info";
        } else {
            $usergeometries = null;
            $title = "New Polyline Geometry Info";
        }
        return array('id' => $id, 'index' => $index,'title'=>$title, 'usergeometry' => $usergeometries, 'userdrawlayers' => $userdrawlayers, 'name' => $name, 'radius' => $radius);
    }

    /**
     * get feature extend.
     * params: ogc_fid and userboundary_id
     * @Route("/polygon", name="draw_polygon", options={"expose"=true})
     * @Method("GET|POST")
     * @Template()
     */
    public function polygonAction(Request $request) {
       
        $index = $request->get('index');
        $id = $request->get('id');
        $name = $request->get('name');
        $radius = $request->get('radius');
        $em = $this->getDoctrine()->getManager();
        $userdrawlayers = $em->getRepository('Map2uCoreBundle:UserDrawLayer')->findAll();
        if (isset($id) && $id > 0) {
            $usergeometries = $em->getRepository('ApplicationMap2uCoreBundle:UserDrawGeometries')->findOneBy(array("id" => $id));
            $title = "Update Polygon Geometry Info";
        } else {
            $usergeometries = null;
            $title = "New Polygon Geometry Info";
        }

        return array('id' => $id,'title'=>$title, 'index' => $index, 'usergeometry' => $usergeometries, 'userdrawlayers' => $userdrawlayers, 'name' => $name, 'radius' => $radius);
    }

    /**
     * get feature extend.
     * params: ogc_fid and userboundary_id
     * @Route("/rectangle", name="draw_rectangle", options={"expose"=true})
     * @Method("GET|POST")
     * @Template()
     */
    public function rectangleAction(Request $request) {
      
        $index = $request->get('index');
        $id = $request->get('id');
        $name = $request->get('name');
        $radius = $request->get('radius');
        $em = $this->getDoctrine()->getManager();
        $userdrawlayers = $em->getRepository('Map2uCoreBundle:UserDrawLayer')->findAll();
        if (isset($id) && $id > 0) {
            $usergeometries = $em->getRepository('ApplicationMap2uCoreBundle:UserDrawGeometries')->findOneBy(array("id" => $id));
            $title = "Update Rectangle Geometry Info";
        } else {
            $usergeometries = null;
            $title = "New Rectangle Geometry Info";
        }

        return array('id' => $id, 'title' => $title, 'index' => $index, 'usergeometry' => $usergeometries, 'userdrawlayers' => $userdrawlayers, 'name' => $name, 'radius' => $radius);
    }

    /**
     * get feature extend.
     * params: ogc_fid and userboundary_id
     * @Route("/circle", name="draw_circle", options={"expose"=true})
     * @Method("GET|POST")
     * @Template()
     */
    public function circleAction(Request $request) {
       
        $index = $request->get('index');
        $id = $request->get('id');
        $name = $request->get('name');
        $radius = $request->get('radius');
        $em = $this->getDoctrine()->getManager();
        $userdrawlayers = $em->getRepository('Map2uCoreBundle:UserDrawLayer')->findAll();
        if (isset($id) && $id > 0) {
            $usergeometries = $em->getRepository('ApplicationMap2uCoreBundle:UserDrawGeometries')->findOneBy(array("id" => $id));
            $title = "Update Circle Geometry Info";
        } else {
            $usergeometries = null;
            $title = "New Circle Geometry Info";
        }
        return array('id' => $id, 'title' => $title, 'index' => $index, 'usergeometry' => $usergeometries, 'userdrawlayers' => $userdrawlayers, 'name' => $name, 'radius' => $radius);
    }

    /**
     * get feature extend.
     * params: ogc_fid and userboundary_id
     * @Route("/marker", name="draw_marker", options={"expose"=true})
     * @Method("GET|POST")
     * @Template()
     */
    public function markerAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $markers = array();
        $user = $this->getUser();
        $icon_path = $this->get('kernel')->getRootDir() . '/../web/images/markers';
        if ($user) {
            foreach (glob($icon_path . '/' . $user->getId() . '/*.*') as $file) {
                $file1 = substr($file, 0, strrpos($file, '/', -1));
                $file2 = substr($file, 0, strrpos($file1, '/', -1));
                $markers[substr($file, strlen($file2) + 1)] = substr($file, strlen($file2) + 1);
            }
        }
        foreach (glob($icon_path . '/*.*') as $file) {
            $markers[substr($file, strrpos($file, '/', -1) + 1)] = substr($file, strrpos($file, '/', -1) + 1);
        }

    
        $index = $request->get('index');
        $id = $request->get('id');
        $name = $request->get('name');
        $userdrawlayers = $em->getRepository('Map2uCoreBundle:UserDrawLayer')->findAll();

        if (isset($id) && $id > 0) {
            $usergeometries = $em->getRepository('ApplicationMap2uCoreBundle:UserDrawGeometries')->findOneBy(array("id" => $id));
            $title = "Update Marker Geometry Info";
        } else {
            $usergeometries = null;
            $title = "New Marker Geometry Info";
        }
        $radius = $request->get('radius');
        return array('id' => $id, 'title' => $title, 'index' => $index, 'usergeometry' => $usergeometries, 'userdrawlayers' => $userdrawlayers, 'name' => $name, 'radius' => $radius, 'markers' => $markers);
    }

    /**
     * get feature extend.
     * params: ogc_fid and userboundary_id
     * @Route("/save", name="draw_save", options={"expose"=true})
     * @Method("GET|POST")
     * @Template()
     */
    public function saveAction(Request $request) {

        $user = $this->getUser();
        if (!isset($user) || empty($user)) {
            return new Response(\json_encode(array('success' => false, 'message' => 'Must be a logged in user!')));
        }

        $id = $request->get('id');
        $drawname = $request->get('name');
        $public = $request->get('public');
        $feature = $request->get('feature');
        $featurelayer_id = $request->get('featurelayer');
        if (gettype($feature) == 'string') {
            $feature = json_decode($feature);
        }
        $drawradius = $request->get('radius');
        $drawtype = $request->get('type');
        $drawbuffer = $request->get('buffer');
        $upload_marker_icon = $request->files->get('upload_marker_icon');

        $updateGeom = false;
//    var_dump($feature);
        $em = $this->getDoctrine()->getManager();
        if (!isset($id)) {
            return new Response(\json_encode(array('success' => false, 'message' => 'Parameter Id not found!')));
        }
        if (isset($id) && ( $id === 0 || $id === '0' || $id === 'undefined' || $id === null)) {
            $usergeometries = new UserDrawGeometries();
            $usergeometries->setUserId($user->getId());
            $usergeometries->setUser($user);
        } else {
            $usergeometries = $em->getRepository('Map2uCoreBundle:UserDrawGeometries')->find($id);
            $updateGeom = true;
        }
        if ($usergeometries) {
            if (isset($featurelayer_id) && $featurelayer_id != null) {
                $featurelayer = $em->getRepository('Map2uCoreBundle:UserDrawLayer')->find($featurelayer_id);
                $usergeometries->setUserdrawlayer($featurelayer);
            }
            $usergeometries->setUserId($user->getId());
            //    $usergeometries->setUserId(1);
            if ($upload_marker_icon) {
                if (!file_exists($icon_path . "/" . $user->getId())) {
                    mkdir($icon_path . "/" . $user->getId(), 0755, true);
                }
                move_uploaded_file($upload_marker_icon->getPathname(), $icon_path . "/" . $user->getId() . "/" . $upload_marker_icon->getClientOriginalName());
                $selected_marker = $user->getId() . "/" . $upload_marker_icon->getClientOriginalName();
                $usergeometries->setMarkerIcon($selected_marker);
            } else {
                if (isset($selected_marker)) {
                    $usergeometries->setMarkerIcon($selected_marker);
                }
            }
            $usergeometries->setName($drawname);
            $usergeometries->setGeomType($drawtype);
            if (isset($public))
                $usergeometries->setPublic($public);
            $usergeometries->setRadius($drawradius);
            $usergeometries->setBuffer($drawbuffer);
            $em->persist($usergeometries);
            $em->flush();
            $usergeometriesId = $usergeometries->getId();

            //    $conn = $this->get('database_connection');
            //    $featureGeojson = json_encode($feature['geometry']);
            if ($drawtype === 'circle' || $drawtype === 'marker') {
                $lng = $feature->geometry->coordinates[0];
                $lat = $feature->geometry->coordinates[1];
                if ($updateGeom === true) {
                    $sql = "UPDATE userdrawgeometries_geom set the_geom = ST_GeomFromText('POINT($lng $lat)', 4326) where userdrawgeometries_id=$usergeometriesId";
                } else {

                    //     $sql = "INSERT INTO userdrawgeometries_geom (userdrawgeometries_id,the_geom) VALUES($usergeometriesId, st_geomfromgeojson('$featureGeojson'))";
                    $sql = "INSERT INTO userdrawgeometries_geom (userdrawgeometries_id,the_geom) VALUES($usergeometriesId, ST_GeomFromText('POINT($lng $lat)', 4326))";
                }
            }
            if ($drawtype === 'rectangle' || $drawtype === 'polygon') {
                $points = '';
                // var_dump(count($feature['geometry']['coordinates'][0]));

                foreach ($feature->geometry->coordinates[0] as $point) {

                    if ($points === '') {
                        $points = "$point[0]  $point[1]";
                    } else {
                        $points = $points . ",$point[0]  $point[1]";
                    }
                }
                if ($updateGeom === true) {
                    $sql = "UPDATE userdrawgeometries_geom set the_geom = ST_GeomFromText('POLYGON(($points))', 4326) where userdrawgeometries_id=$usergeometriesId";
                } else {
                    //     $sql = "INSERT INTO userdrawgeometries_geom (userdrawgeometries_id,the_geom) VALUES($usergeometriesId, st_geomfromgeojson('$featureGeojson'))";
                    $sql = "INSERT INTO userdrawgeometries_geom (userdrawgeometries_id,the_geom) VALUES($usergeometriesId, ST_GeomFromText('POLYGON(($points))', 4326))";
                }
            }
            if ($drawtype === 'polyline') {
                $points = '';
                //    var_dump(count($feature['geometry']['coordinates']));
                //        var_dump($feature['geometry']['coordinates']);
                foreach ($feature->geometry->coordinates as $point) {

                    if ($points === '') {
                        $points = "$point[0]  $point[1]";
                    } else {
                        $points = $points . ",$point[0]  $point[1]";
                    }
                }
                if ($updateGeom === true) {
                    $sql = "UPDATE userdrawgeometries_geom set the_geom = ST_GeomFromText('LINESTRING($points)', 4326) where userdrawgeometries_id=$usergeometriesId";
                } else {

                    //     $sql = "INSERT INTO userdrawgeometries_geom (userdrawgeometries_id,the_geom) VALUES($usergeometriesId, st_geomfromgeojson('$featureGeojson'))";
                    $sql = "INSERT INTO userdrawgeometries_geom (userdrawgeometries_id,the_geom) VALUES($usergeometriesId, ST_GeomFromText('LINESTRING($points)', 4326))";
                }
            }
            $stmt = $conn->query($sql);
            // $response = new JsonResponse(array('success' => true, 'data' => $stmt));


            $this->moveuploadedImages($request, $em, $usergeometries);
            $this->moveuploadedVideo($request, $em, $usergeometries);
            $this->moveuploadedAudio($request, $em, $usergeometries);

            return new Response(\json_encode(array('success' => true, 'id' => $usergeometriesId)));
        } else {
            return new Response(\json_encode(array('success' => false, 'id' => $usergeometriesId, 'message' => 'User draw geometry id:' . $usergeometriesId . ' not found!')));
        }


        // st_geomfromgeojson (text)?

        return new Response(\json_encode(array('success' => false)));
    }

    /**
     * get feature extend.
     * params: ogc_fid and userboundary_id
     * @Route("/update", name="draw_update", options={"expose"=true})
     * @Method("GET|POST")
     * @Template()
     */
    public function updateAction(Request $request) {
        return array();
    }

    /**
     * get feature extend.
     * params: ogc_fid and userboundary_id
     * @Route("/delete", name="draw_delete", options={"expose"=true})
     * @Method("POST")
     * @Template()
     */
    public function deleteAction(Request $request) {

        $user = $this->getUser();
        if (!isset($user) || empty($user)) {
            return new Response(\json_encode(array('success' => false, 'message' => 'Must be a logged in user!')));
        }
      
        $id = $request->get('id');

        $em = $this->getDoctrine()->getManager();
        if (!isset($id)) {
            return new Response(\json_encode(array('success' => false, 'message' => 'Parameter Id not found!')));
        }

        $usergeometries = $em->getRepository('Map2uCoreBundle:UserDrawGeometries')->find($id);
        if ($usergeometries) {
            $em->remove($usergeometries);
            $em->flush();
            return new Response(\json_encode(array('success' => true, 'message' => 'successfully deleted!')));
        } else {
            return new Response(\json_encode(array('success' => false, 'message' => 'ID:' . $id . ' user draw geometry not found!')));
        }
    }

    /**
     * get feature extend.
     * params: ogc_fid and userboundary_id
     * @Route("/drawcontent", name="draw_content", options={"expose"=true})
     * @Method("GET")
     * @Template()
     */
    public function drawcontentAction(Request $request) {


    
        $id = $request->get('id');

        $em = $this->getDoctrine()->getManager();
        if (!isset($id)) {
            return new Response(\json_encode(array('success' => false, 'message' => 'Parameter Id not found!')));
        }

        $usergeometries = $em->getRepository('ApplicationMap2uCoreBundle:UserDrawGeometries')->find($id);
        if ($usergeometries) {

            return array('success' => true, 'usergeometries' => $usergeometries, 'message' => 'successfully deleted!');
        } else {
            return new Response(\json_encode(array('success' => false, 'usergeometries' => null, 'message' => 'ID:' . $id . ' user draw geometry not found!')));
        }
    }

    protected function moveuploadedImages($request, $em, $usergeometries) {
        $images_file = $request->files->get('images');
        $images_array = array();

        $dir = '/uploads/usergeometries/' . $this->getUser()->getId();

        if (file_exists("." . $dir . '/pictures/' . $usergeometries->getId()) == false) {
            shell_exec("mkdir -p ." . $dir . '/pictures/' . $usergeometries->getId());
        }

        if (is_array($images_file)) {
            foreach ($images_file as $file) {
                if ($file != null) {



                    array_push($images_array, $dir . '/pictures/' . $usergeometries->getId() . '/' . str_replace(' ', '-', trim($file->getClientOriginalName())));
                    $file->move("." . $dir . '/pictures/' . $usergeometries->getId(), str_replace(' ', '-', trim($file->getClientOriginalName())));
                }
            }
        } else {
            if ($images_file != null) {
                array_push($images_array, $dir . '/pictures/' . $usergeometries->getId() . '/' . str_replace(' ', '-', trim($images_file->getClientOriginalName())));
                $images_file->move("." . $dir . '/pictures/' . $usergeometries->getId(), str_replace(' ', '-', trim($images_file->getClientOriginalName())));
            }
        }
        $usergeometries->setImages(serialize($images_array));
        $em->persist($usergeometries);
        $em->flush();
    }

    protected function moveuploadedVideo($request, $em, $usergeometries) {

        $videos_file = $request->files->get('video');
        $videos_array = array();
        $dir = '/uploads/usergeometries/' . $this->getUser()->getId();
        if (file_exists("." . $dir . '/videos/' . $usergeometries->getId()) == false) {
            shell_exec("mkdir -p ." . $dir . '/videos/' . $usergeometries->getId());
        }

        if (is_array($videos_file)) {
            foreach ($videos_file as $file) {
                if ($file != null) {
                    array_push($videos_array, $dir . '/videos/' . $usergeometries->getId() . '/' . str_replace(' ', '-', trim($file->getClientOriginalName())));
                    $file->move("." . $dir . '/videos/' . $usergeometries->getId(), str_replace(' ', '-', trim($file->getClientOriginalName())));
                }
            }
        } else {
            if ($videos_file != null) {
                array_push($videos_array, $dir . '/videos/' . $usergeometries->getId() . '/' . str_replace(' ', '-', trim($videos_file->getClientOriginalName())));
                $videos_file->move("." . $dir . '/videos/' . $usergeometries->getId(), str_replace(' ', '-', trim($videos_file->getClientOriginalName())));
            }
        }
        $usergeometries->setVideo(serialize($videos_array));
        $em->persist($usergeometries);
        $em->flush();
    }

    protected function moveuploadedAudio($request, $em, $usergeometries) {
        $audios_file = $request->files->get('audio');
        $audios_array = array();

        $dir = '/uploads/usergeometries/' . $this->getUser()->getId();
        if (file_exists("." . $dir . '/audios/' . $usergeometries->getId()) == false) {
            shell_exec("mkdir -p ." . $dir . '/audios/' . $usergeometries->getId());
        }
        if (is_array($audios_file)) {
            foreach ($audios_file as $file) {

                if ($file != null) {
                    array_push($audios_array, $dir . '/audios/' . $usergeometries->getId() . '/' . str_replace(' ', '-', trim($file->getClientOriginalName())));
                    $file->move("." . $dir . '/audios/' . $usergeometries->getId(), str_replace(' ', '-', trim($file->getClientOriginalName())));
                }
            }
        } else {
            if ($audios_file != null) {
                array_push($audios_array, $dir . '/audios/' . $usergeometries->getId() . '/' . str_replace(' ', '-', trim($audios_file->getClientOriginalName())));
                $audios_file->move("." . $dir . '/audios/' . $usergeometries->getId(), str_replace(' ', '-', trim($audios_file->getClientOriginalName())));
            }
        }
        $usergeometries->setAudio(serialize($audios_array));
        $em->persist($usergeometries);
        $em->flush();
    }

    /**
     * show welcome page.
     *
     * @Route("/mytest", name="draw_test",options={"expose"=true})
     * @Method("GET")
     * @Template()
     */
    public function mytestAction() {
        $conn = $this->get('database_connection');
        $admin = '%u%';
        $sql = "SELECT  * FROM useruploadfile WHERE lower(file_name) like :tag";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':tag', $admin);
        // $stmt->bindParam(':username', $admin);

        $stmt->execute();
        var_dump(count($stmt->fetchAll()));
    }

}
