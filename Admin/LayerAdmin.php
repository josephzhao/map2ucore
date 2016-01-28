<?php

namespace Map2u\CoreBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class LayerAdmin extends Admin {

    protected $container;

    /**
     * @param DatagridMapper $datagridMapper
     */
    public function __construct($code, $class, $baseControllerName, $container = null) {
        parent::__construct($code, $class, $baseControllerName);
        $this->container = $container;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper) {
        $datagridMapper
                ->add('userId')
                ->add('tableId')
                ->add('tableName')
                ->add('rowId')
                ->add('enabled')
                ->add('public')
                ->add('position')
                ->add('shared')
                ->add('layerProperty')
                ->add('showLabel')
                ->add('defaultShowOnMap')
                ->add('layerShowInSwitcher')
                ->add('zoomLevel')
                ->add('lat')
                ->add('lng')
                ->add('projectId')
                ->add('name')
                ->add('type')
                ->add('valueField')
                ->add('sld')
                ->add('sql')
                ->add('sessionId')
                ->add('createdAt')
                ->add('updatedAt')
                ->add('description')
                ->add('id')
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper) {
        $listMapper
                ->add('user')
                ->add('name')
                ->add('enabled')
                ->add('public')
                ->add('position')
                ->add('shared')
                ->add('layerProperty')
                ->add('showLabel')
                ->add('defaultShowOnMap')
                ->add('layerShowInSwitcher')
                ->add('zoomLevel')
                ->add('lat')
                ->add('lng')
              
                ->add('type')
                ->add('valueField')
                ->add('sld')
                ->add('sql')
                ->add('id')
                ->add('_action', 'actions', array(
                    'actions' => array(
                        'show' => array(),
                        'edit' => array(),
                        'delete' => array(),
                    )
                ))
        ;
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper) {
        $sldFiles = array();
        $path = $this->container->get('kernel')->getRootDir() . '/../Data';
        $user = $this->container->get('security.context')->getToken()->getUser();

        if (file_exists($path . '/sld/' . $user->getId())) {
            foreach (glob($path . '/sld/' . $user->getId() . '/*.sld') as $file) {
                $file1 = substr($file, 0, strrpos($file, '/', -1));
                $file2 = substr($file, 0, strrpos($file1, '/', -1));
                $sldFiles[substr($file, strlen($file2) + 1)] = substr($file, strlen($file2) + 1);
            }
        }
        foreach (glob($path . '/sld/*.sld') as $file) {
            $sldFiles[substr($file, strrpos($file, '/', -1) + 1)] = substr($file, strrpos($file, '/', -1) + 1);
        }

        $spatialfile_class = $this->getConfigurationPool()->getContainer()->getParameter('map2u.core.spatialfile.class');
        $formMapper
                ->tab('General')
                ->with('Layer', array('class' => 'col-md-6'))
                ->add('id', 'hidden')
                ->add('name')
                ->add('user')
                ->add('spatialfile', 'entity', array(
                    'class' => $spatialfile_class,
                    'required' => false,
                    'multiple' => false,
                    'expanded' => false
                ))
                ->add('layerCategory', 'entity', array(
                    'class' => "Map2u\CoreBundle\Entity\LayerCategory",
                    'required' => false,
                    'multiple' => false,
                    'expanded' => false
                ))
                ->add('category', 'entity', array(
                    'class' => "Map2u\CoreBundle\Entity\Category",
                    'required' => false,
                    'multiple' => false,
                    'expanded' => false
                ))
                ->add('enabled')
                ->add('public')
                ->add('position')
                ->end()
                ->with('Layer Translation', array('class' => 'col-md-6'))
                ->add('translations', 'a2lix_translations', array(
                    'by_reference' => false,
                    'required' => false))
                ->end()
                ->end()
                ->tab('WMS and WFS Layer')
                ->with('WMS and WFS Layer Settings', array('class' => 'col-md-6'))
                ->add('hostName', 'text', array('mapped' => false, 'required' => false))
                ->add('layerName', 'text', array('mapped' => false, 'required' => false))
                ->add('srs', 'text', array('mapped' => false, 'required' => false))
                ->add('layerType', 'choice', array('mapped' => false, 'choices' => array('wms' => 'WMS', 'wfs' => 'WFS')))
                ->end()
                ->end()
                ->tab('Heat Map Layer')
                ->with('Heat Map Layer Settings', array('class' => 'col-md-6'))
                ->add('fieldname','text',array('mapped' => false, 'required' => false))
                ->add('radius','text',array('mapped' => false, 'required' => false))
                ->add('opacity','number',array('mapped' => false, 'required' => false))
                ->add('gradient','text',array('mapped' => false, 'required' => false))
                ->end()
                ->end()
                ->tab('Cluster Layer')
                ->with('Cluster Settings', array('class' => 'col-md-6'))
                ->add('showCoverageOnHover', 'checkbox', array('mapped' => false, 'required' => false,'data' => true))
                ->add('zoomToBoundsOnClick',  'checkbox', array('mapped' => false, 'required' => false,'data' => true))
                ->add('spiderfyOnMaxZoom',  'checkbox', array('mapped' => false, 'required' => false,'data' => true))
                ->add('removeOutsideVisibleBounds',  'checkbox', array('mapped' => false, 'required' => false,'data' => true))
                ->add('animateAddingMarkers',  'checkbox', array('mapped' => false, 'required' => false,'data' => true))
                ->add('disableClusteringAtZoom','integer',array('mapped' => false, 'required' => false))
                ->add('maxClusterRadius', 'number', array('mapped' => false, 'required' => false,'data' => 80))
                ->add('polygonOptions','text',array('mapped' => false, 'required' => false))
                ->add('singleMarkerMode',  'checkbox', array('mapped' => false, 'required' => false,'data' => true))
                ->add('spiderfyDistanceMultiplier', 'integer', array('mapped' => false, 'required' => false,'data' => 1))
                ->add('iconCreateFunction','text',array('mapped' => false, 'required' => false))
                ->end()
                ->end()
                ->tab('Style and Settings')
                ->with('Layer Style', array('class' => 'col-md-6'))
                ->add('shared')
                ->add('layerProperty')
                ->add('showLabel')
                ->add('defaultShowOnMap')
                ->add('layerShowInSwitcher')
                ->add('zoomLevel')
                ->add('defaultSldName', 'choice', array('mapped' => false, 'choices' => $sldFiles, 'label' => 'Default SLD File'))
                ->add('uploadSldName', 'file', array('mapped' => false, 'required' => false, 'label' => 'Upload SLD File', 'attr' => array('style' => 'border: none')))
                ->end()
                ->with('Layer Settings', array('class' => 'col-md-6'))
                ->add('lat')
                ->add('lng')
                ->add('type')
                ->add('valueField')
                ->add('sld')
                ->add('sql')
                ->end()
                ->end()


        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper) {
        $showMapper
                ->add('userId')
                ->add('tableId')
                ->add('tableName')
                ->add('rowId')
                ->add('enabled')
                ->add('public')
                ->add('position')
                ->add('shared')
                ->add('layerProperty')
                ->add('showLabel')
                ->add('defaultShowOnMap')
                ->add('layerShowInSwitcher')
                ->add('zoomLevel')
                ->add('lat')
                ->add('lng')
                //           ->add('projectId')
                ->add('name')
                ->add('type')
                ->add('valueField')
                ->add('sld')
                ->add('sql')
                ->add('sessionId')
                ->add('createdAt')
                ->add('updatedAt')
                ->add('description')
                ->add('id')
        ;
    }

}
