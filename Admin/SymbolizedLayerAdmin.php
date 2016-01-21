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
                ->add('category', 'entity', array(
                    'class' => "Map2u\CoreBundle\Entity\LayerCategory",
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
