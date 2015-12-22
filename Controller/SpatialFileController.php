<?php

namespace Map2u\CoreBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Map2u\CoreBundle\Classes\SpatialFileMethods;
use Map2u\CoreBundle\Classes\DatabaseMethods;
use Map2u\CoreBundle\Entity\SpatialFile;
use Map2u\CoreBundle\Form\SpatialFileType;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

/**
 * Map2u Core SpatialFile controller.
 *
 * @Route("/spatialfile")
 */
class SpatialFileController extends Controller {

    private $params = null;
    protected $entity = null;
    protected $entityType = null;

    public function __construct() {

        $this->entity = new SpatialFile();
        $this->entityType = new SpatialFileType();
    }

    /**
     * SpatialFile controller sample_format action.
     * This will function will display sample data format
     * and create json file export from database for just uploaded files with json extension
     * and also create topojson file fron json file
     * @Route("/sample_format" , name="spatialfile_sample_format", options={"expose"=true})
     * @Method({"GET"})
     * @Template()
     */
    public function sample_formatAction(Request $request) {
        return array();
    }

    /**
     * SpatialFile controller sample_format action.
     * This will function will display sample data format
     * and create json file export from database for just uploaded files with json extension
     * and also create topojson file fron json file
     * @Route("/columns" , name="spatialfile_columns", options={"expose"=true})
     * @Method({"GET|POST"})
     * @Template()
     */
    public function columnsAction(Request $request) {

        $spatialfile_id = $request->get("spatialfile_id");
        $em = $this->getDoctrine()->getManager();
        $spatialfile = null;
        $columns = array();
        if (isset($spatialfile_id) && $spatialfile_id !== null) {
            $spatialfile = $em->getRepository($em->getClassMetadata(get_class($this->entity))->getName())->find($spatialfile_id);
        }
        if ($spatialfile) {
            $columns = unserialize($spatialfile->getFieldList());
        }
        if ($request->isXmlHttpRequest()) {
            $response = new JsonResponse(array('columns' => $columns));
            $response->headers->set('Content-Type', 'application/json');
            return $response;
        }
        return array('columns' => $columns);
    }

    /**
     * SpatialFile controller sample_format action.
     * This will function will display sample data format
     * and create json file export from database for just uploaded files with json extension
     * and also create topojson file fron json file
     * @Route("/columndata" , name="spatialfile_columndata", options={"expose"=true})
     * @Method({"GET|POST"})
     * @Template()
     */
    public function columndataAction(Request $request) {

        $spatialfile_id = $request->get("spatialfile_id");
        $column_name = $request->get("column_name");
        $em = $this->getDoctrine()->getManager();
        $spatialfile = null;
        $columns = array();
        if (isset($spatialfile_id) && $spatialfile_id !== null) {
            $spatialfile = $em->getRepository($em->getClassMetadata(get_class($this->entity))->getName())->find($spatialfile_id);
        }
        if ($spatialfile) {
            $columns = unserialize($spatialfile->getFieldList());
        }
        if ($request->isXmlHttpRequest()) {
            $response = new JsonResponse(array('columns' => $columns));
            $response->headers->set('Content-Type', 'application/json');
            return $response;
        }
        return array('columns' => $columns);
    }

    /**
     * SpatialFile controller sample_format action.
     * This will function will display sample data format
     * and create json file export from database for just uploaded files with json extension
     * and also create topojson file fron json file
     * @Route("/info" , name="spatialfile_info", options={"expose"=true})
     * @Method({"GET"})
     * @Template()
     */
    public function infoAction(Request $request) {
        $spatialfile_id = $request->get("spatialfile_id");
        $em = $this->getDoctrine()->getManager();
        $spatialfile = null;
        $user = $this->getUser();
        if (!$user) {
            return new Response(\json_encode(array('success' => false, 'type' => '', 'data' => 'Only logged in user can show map with topojson file data')));
        }
        if (isset($spatialfile_id) && $spatialfile_id !== null) {
            $spatialfile = $em->getRepository($em->getClassMetadata(get_class($this->entity))->getName())->find($spatialfile_id);
        }
        if ($spatialfile !== null) {
            return new Response(\json_encode(array('success' => true, 'spatialfile' => array('id' => $spatialfile->getId(), 'layerType' => 'spatialfile', 'datasource' => $spatialfile->getId(), 'filename' => $spatialfile->getFileName(), 'type' => 'topojson'))));
        }
        return new Response(\json_encode(array('success' => false, 'type' => '', 'spatialfile' => array(), 'data' => 'Spatial file not found!')));
    }

    /**
     * SpatialFile controller sample_format action.
     * This will function will display sample data format
     * and create json file export from database for just uploaded files with json extension
     * and also create topojson file fron json file
     * @Route("/geomdata" , name="spatialfile_geomdata", options={"expose"=true})
     * @Method({"GET|POST"})
     * @Template()
     */
    public function geomdataAction(Request $request) {
        $spatialfile_id = $request->get("spatialfile_id");
        $em = $this->getDoctrine()->getManager();
        $fileName = null;
        $layer = array();
        if (isset($spatialfile_id) && $spatialfile_id !== null) {
            $dir = $this->get('kernel')->getRootDir() . '/../Data/uploads/spatialfiles/spatial_' . str_replace('-', '_', $spatialfile_id);
            $spatialfile = $em->getRepository($em->getClassMetadata(get_class($this->entity))->getName())->find($spatialfile_id);
            if ($spatialfile) {
                $fileName = $spatialfile->getFileName();
            }
            if (file_exists($dir . "/1spatial_" . str_replace('-', '_', $spatialfile_id) . ".zip") === true) {
                $theGeom = file_get_contents($dir . "/spatial_" . str_replace('-', '_', $spatialfile_id) . ".zip");
                $geom['geom'] = $theGeom;
                $geom['datatype'] = "topojson";
                $layer['fileName'] = $fileName;
                return new JsonResponse(array("success" => true, 'layer' => $layer, 'datatype' => "zip", "geomdata" => $geom));
            }
            if (file_exists($dir . "/spatial_" . str_replace('-', '_', $spatialfile_id) . ".topojson") === true) {
                $theGeom = file_get_contents($dir . "/spatial_" . str_replace('-', '_', $spatialfile_id) . ".topojson");
                $geom['geom'] = $theGeom;
                $geom['datatype'] = "topojson";
                $layer['fileName'] = $fileName;
                return new JsonResponse(array("success" => true, 'layer' => $layer, 'datatype' => "topojson", "geomdata" => $geom));
            }
        }
        return array("spatialfile" => null);
    }

    /**
     * SpatialFile controller upload shapefile action.
     * This will function will create folder under Data/uploads/spatialfiles/{id}
     * and create json file export from database for just uploaded files with json extension
     * and also create topojson file fron json file
     * @Route("/upload" , name="spatialfile_upload", options={"expose"=true})
     * @Method({"POST"})
     */
    public function uploadAction(Request $request) {

        $form = $this->createFormBuilder()
                ->add('categories', 'entity', array(
                    'label' => 'Categories:',
                    'class' => 'Map2uCoreBundle:Category',
                    'multiple' => false,
                    'empty_data' => DefaultMethods::gen_uuid(),
                    'property' => 'name'
                ))
                ->add('tags', 'entity', array(
                    'label' => 'Tags:',
                    'class' => 'Map2uCoreBundle:Tag',
                    'multiple' => false,
                    'empty_data' => DefaultMethods::gen_uuid(),
                    'property' => 'name'))
                ->add('spatial_file', 'file', array('attr' => array('multiple' => true)))
                ->getForm();
        if (!$this->getUser()) {
            return new Response(\json_encode(array('success' => false, 'message' => 'Only logged in user can upload file to server')));
        }
        if ($request->getMethod() !== "POST") {
            return new Response(\json_encode(array('success' => false, 'message' => 'Only post method will be used here for uploading shape file to server')));
        }
        $this->params = $this->getPostedSpatialfileParams($request);

        $form->handleRequest($request);
        if ($form->isSubmitted()) {

            $path = getenv('PATH');
            putenv("PATH=$path:/opt/local/bin");
            $data = $form->getData();
            // $files = $data['shape_file'];
            $files = $data['spatial_file'];
            $this->params['categories'] = null;
            if (isset($data['categories'])) {
                $this->params['categories'] = $data['categories'];
            }

            $this->params['tags'] = null;
            if (isset($data['tags'])) {
                $this->params['tags'] = $data['tags'];
            }

            if ($files === null || (is_array($files) && $files[0] === null)) {
                return new JsonResponse(array('success' => false, 'message' => "No upload file selected!"));
            }
            list($filetype, $spatialfilename, $sheetnames) = SpatialFileMethods::getSpatialFileType($files);

            list( $runResults, $spatialfiles ) = $this->processUploadedSpatialFiles($files, $filetype, $spatialfilename, $sheetnames);
            return new JsonResponse(array('success' => true, 'message' => 'Files successfully uploaded!', 'spatialfiles' => $this->getSpatialFile($spatialfiles), "result_messages" => $runResults));
        }
        return new JsonResponse(array('success' => false, 'message' => 'Files not successfully uploaded!'));
    }

    private function processUploadedSpatialFiles($files, $filetype, $spatialfilename, $sheetnames) {

        $spatialfiles = array();
        $runResults = array();
        if ($sheetnames !== null && is_array($sheetnames)) {
            foreach ($sheetnames as $sheetname) {
                list($runResult, $spatialfile) = $this->processEachSpatialFile($files, $filetype, $spatialfilename, $sheetname, true);
                array_push($spatialfiles, $spatialfile);
                array_push($runResults, $runResult);
            }
        } else {
            list($runResult, $spatialfile) = $this->processEachSpatialFile($files, $filetype, $spatialfilename, $sheetnames);
            array_push($spatialfiles, $spatialfile);
            array_push($runResults, $runResult);
        }
        return [$runResults, $spatialfiles];
    }

    private function processEachSpatialFile($files, $filetype, $spatialfilename, $sheetname, $bexcel = false) {
        $dbparams = DefaultMethods::getDatabaseParams($this);
        $em = $this->getDoctrine()->getManager();
        $runResult = null;

        $spatialfile = $em->getRepository($em->getClassMetadata(get_class($this->entity))->getName())->findOneBy(array("userId" => $this->getUser()->getId(), "fileName" => $spatialfilename, 'sheetName' => $sheetname));
        if ($spatialfile === null) {
            $entityInfo = $em->getClassMetadata(get_class($this->entity));
            $spatialfile = new $entityInfo->name;
            $spatialfile->setUserId($this->getUser()->getId());
            $spatialfile->setUser($this->getUser());
        }
        if (count($spatialfile->getCategories()) > 0) {
            foreach ($spatialfile->getCategories() as $category) {
                $spatialfile->removeCategory($category);
            }
        }
        if ($this->params['categories'] !== null) {
            $spatialfile->addCategory($this->params['categories']);
        }
        if (count($spatialfile->getTags()) > 0) {
            foreach ($spatialfile->getTags() as $tag) {
                $spatialfile->removeTag($tag);
            }
        }
        if ($this->params['tags'] !== null) {
            $spatialfile->addTag($this->params['tags']);
        }
        $spatialfile->setFileType($filetype);
        $spatialfile->setSupportType($this->params['spatial_typeid']);

        $spatialfile->setSessionId($this->params['sessionid']);
        $spatialfile->setFileName($spatialfilename);
        $spatialfile->setSheetName($sheetname);
        $em->persist($spatialfile);
        $em->flush();

        $id = str_replace('-', '_', $spatialfile->getId());

        $dir = $this->get('kernel')->getRootDir() . '/../Data/uploads/spatialfiles/spatial_' . str_replace('-', '_', $id);
        if (file_exists($dir) === false) {
            shell_exec('mkdir -p ' . $dir);
        }

        $filenames = SpatialFileMethods::saveSpatialFile($dir, $files, $bexcel);
        if (count($filenames) > 0 && ($filetype === 'shapefile' || $filetype === 'mapinfo' || $filetype === 'kml')) {
            $runResult = SpatialFileMethods::ogr2ogrToDatabase($dir, $spatialfile, $dbparams);

            if ($runResult === null) {
                DefaultMethods::setDatabaseTableUUID($this, "spatial_" . $id);
                $columns = DefaultMethods::getTableColumns($this, "spatial_" . $id);
                $geo_type = DefaultMethods::getGeometryType($this->get("database_connection"), "spatial_" . $id, 'the_geom');
                $spatialfile->setFieldList(serialize($columns));
                SpatialFileMethods::ogr2ogrDatabaseToGeoJSON($dir, $spatialfile, $dbparams, $geo_type);
                $em->persist($spatialfile);
            } else {
                $em->remove($spatialfile);
            }
        } else {
            $runResult = $this->processTextfileDataToDatabase($dir, $spatialfile, $sheetname, $bexcel);

            if ($runResult === null) {
                DefaultMethods::setDatabaseTableUUID($this, "spatial_" . $id);
                $columns = DefaultMethods::getTableColumns($this, "spatial_" . $id);
                $spatialfile->setFieldList(serialize($columns));
                $geo_type = DefaultMethods::getGeometryType($this->get("database_connection"), "spatial_" . $id, 'the_geom');
                SpatialFileMethods::ogr2ogrDatabaseToGeoJSON($dir, $spatialfile, $dbparams, $geo_type);
                $em->persist($spatialfile);
            } else {
                $em->remove($spatialfile);
            }
        }

        $em->flush();
        return [$runResult, $spatialfile];
    }

    private function processTextfileDataToDatabase($dir, $spatialfile, $sheetname, $bexcel) {
        $conn = $this->get('database_connection');
        $runResult = null;
        if ($bexcel === true) {
            $field_names = SpatialFileMethods::excelToDatabase($conn, $dir, $spatialfile, $sheetname);
            if ($field_names !== null && count($field_names) > 0) {
                SpatialFileMethods::updateTableGeommetry($this->params, $conn, 'spatial_' . str_replace('-', '_', $spatialfile->getId()));
            } else {
                $runResult = "uploaded excel file:" . $spatialfile->getFileName() . " no field name found!";
            }
        } else {
            $field_names = SpatialFileMethods::textToDatabase($conn, $dir, $spatialfile);
            if ($field_names !== null && count($field_names) > 0) {
                SpatialFileMethods::updateTableGeommetry($this->params, $conn, 'spatial_' . str_replace('-', '_', $spatialfile->getId()));
            } else {
                $runResult = "uploaded text file:" . $spatialfile->getFileName() . " no field name found!";
            }
        }
        return $runResult;
    }

    private function getPostedSpatialfileParams($request) {
        $params = array();
        $params['spatial_typeid'] = $request->get('spatial_typeid');
        $params['sessionid'] = $request->getSession()->getId();
        $params['spatial_sheetname_index'] = preg_replace('/\xc2\xa0/', '', str_replace(" ", "_", strtolower($request->get('spatial_sheetname_index'))));
        $params['spatial_sheetname'] = preg_replace('/\xc2\xa0/', '', str_replace(" ", "_", strtolower($request->get('spatial_sheetname'))));
        $sheetnames = $request->get('spatial_sheetnames');
        if (gettype($sheetnames) === 'string') {
            $sheetnames = json_decode(strtolower($sheetnames));
        }


        if ($params['spatial_sheetname'] === null && intval($params['spatial_sheetname_index']) >= 0 && intval($params['spatial_sheetname_index']) < count($sheetnames)) {
            $params['spatial_sheetname'] = $sheetnames[intval($params['spatial_sheetname_index'])];
        }
        $params['sheetnames'] = $sheetnames;
        $params['spatial_loc_name'] = preg_replace('/\xc2\xa0/', '', str_replace(" ", "_", strtolower($request->get('spatial_loc_name'))));
        $params['spatial_loc_radius'] = preg_replace('/\xc2\xa0/', '', str_replace(" ", "_", strtolower($request->get('spatial_loc_radius'))));
        $params['spatial_geographic_id'] = preg_replace('/\xc2\xa0/', '', str_replace(" ", "_", strtolower($request->get('spatial_geographic_id'))));
        $params['spatial_geographic_level'] = preg_replace('/\xc2\xa0/', '', str_replace(" ", "_", strtolower($request->get('spatial_geographic_level'))));
        $params['spatial_loc_pc'] = preg_replace('/\xc2\xa0/', '', str_replace(" ", "_", strtolower($request->get('spatial_loc_pc'))));
        $params['spatial_loc_lat'] = preg_replace('/\xc2\xa0/', '', str_replace(" ", "_", strtolower($request->get('spatial_loc_lat'))));
        $params['spatial_loc_lon'] = preg_replace('/\xc2\xa0/', '', str_replace(" ", "_", strtolower($request->get('spatial_loc_lon'))));
        $params['spatial_loc_value'] = preg_replace('/\xc2\xa0/', '', str_replace(" ", "_", strtolower($request->get('spatial_loc_count'))));

        return $params;
    }

    protected function getSpatialFile($entities) {
        $spatialfiles = array();
        foreach ($entities as $entity) {
            $spatialfile['id'] = $entity->getId();
            $spatialfile['filename'] = $entity->getFileName();
            $spatialfile['categories'] = $this->getCategories($entity);
            $spatialfile['tags'] = $entity->getTags($entity);
            $spatialfile['updatedAt'] = $entity->getUpdatedAt();
            array_push($spatialfiles, $spatialfile);
        }
        return $spatialfiles;
    }

    private function getCategories($entity) {
        $categories = array();
        if (count($entity->getCategories()) > 0) {
            foreach ($entity->getCategories() as $category) {

                array_push($categories, array("id" => $category->getId(), "name" => $category->getName()));
            }
        }
        return $categories;
    }

    private function getTags($entity) {
        $tags = array();
        if (count($entity->getTags()) > 0) {
            foreach ($entity->getTags() as $tag) {
                array_push($tags, array("id" => $tag->getId(), "name" => $tag->getName()));
            }
        }
        return $tags;
    }

}
