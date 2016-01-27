<?php

namespace Map2u\CoreBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class SymbolizedLayerAdmin extends Admin {

    /**
     * @param DatagridMapper $datagridMapper
     */
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
                ->add('id')
                ->add('seq')
                ->add('minZoom')
                ->add('maxZoom')
                ->add('title')
                ->add('name')
                ->add('defaultSldName')
                ->add('labelField')
                ->add('tipField')
                ->add('defaultShowOnMap')
                ->add('published')
                ->add('public')
                ->add('topojsonOnly')
                ->add('contentFields')
                ->add('layerShowInSwitcher')
                ->add('createdAt')
                ->add('updatedAt')
                ->add('description')
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper) {
        $listMapper
                ->add('id')
                ->add('seq')
                ->add('minZoom')
                ->add('maxZoom')
                ->add('title')
                ->add('name')
                ->add('defaultSldName')
                ->add('labelField')
                ->add('tipField')
                ->add('defaultShowOnMap')
                ->add('published')
                ->add('public')
                ->add('topojsonOnly')
                ->add('contentFields')
                ->add('layerShowInSwitcher')
                ->add('createdAt')
                ->add('updatedAt')
                ->add('description')
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
                ->with('Symbolized Layer', array('class' => 'col-md-6'))
                ->add('id', 'hidden')
                ->add('title')
                ->add('name')
                ->add('seq')
                ->add('layer', 'entity', array(
                    'class' => "Map2u\CoreBundle\Entity\Layer",
                    'required' => true,
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
                ->add('published')
                ->add('published')
                ->add('public')
                ->add('minZoom')
                ->add('maxZoom')
                ->end()
                ->with('Symbolized Layer Settings', array('class' => 'col-md-6'))
                ->add('defaultSldName')
                ->add('labelField')
                ->add('tipField')
                ->add('defaultShowOnMap')
                ->add('topojsonOnly')
                ->add('contentFields')
                ->add('layerShowInSwitcher')
                ->add('description')
                ->end()
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper) {
        $showMapper
                ->add('id')
                ->add('seq')
                ->add('minZoom')
                ->add('maxZoom')
                ->add('title')
                ->add('name')
                ->add('defaultSldName')
                ->add('labelField')
                ->add('tipField')
                ->add('defaultShowOnMap')
                ->add('published')
                ->add('public')
                ->add('topojsonOnly')
                ->add('contentFields')
                ->add('layerShowInSwitcher')
                ->add('createdAt')
                ->add('updatedAt')
                ->add('description')
        ;
    }

}
