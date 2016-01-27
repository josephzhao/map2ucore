<?php

namespace Map2u\CoreBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class MapAdmin extends Admin {

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper) {
        $datagridMapper
                ->add('userId')
                ->add('zoomLevel')
                ->add('mapTitle')
                ->add('name')
                ->add('layerSeq')
                ->add('titlePosition')
                ->add('mapCenter')
                ->add('titleStyle')
                ->add('type')
                ->add('showScale')
                ->add('shared')
                ->add('enabled')
                ->add('public')
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
                ->add('zoomLevel')
                ->add('mapTitle')
                ->add('name')
                ->add('layerSeq')
                ->add('titlePosition')
                ->add('mapCenter')
                ->add('titleStyle')
                ->add('type')
                ->add('showScale')
                ->add('shared')
                ->add('enabled')
                ->add('public')
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
                ->with('Map', array('class' => 'col-md-4'))
                ->add('id', 'hidden')
                ->add('userId')
                ->add('zoomLevel')
                ->add('name')
                ->add('layerSeq')
                ->add('titlePosition')
                ->add('symbolizedLayers', 'entity', array(
                    'class' => "Map2u\CoreBundle\Entity\SymbolizedLayer",
                    'required' => true,
                    'multiple' => true,
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
                ->end()
                ->with('Map Settings', array('class' => 'col-md-4'))
                ->add('mapCenter')
                ->add('titleStyle')
                ->add('type')
                ->add('showScale')
                ->add('shared')
                ->add('enabled')
                ->add('public')
                ->end()
                ->with('Map Translation', array('class' => 'col-md-4'))
                ->add('translations', 'a2lix_translations', array(
                    'by_reference' => false,
                    'required' => false))
                ->end()


        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper) {
        $showMapper
                ->add('userId')
                ->add('zoomLevel')
                ->add('mapTitle')
                ->add('name')
                ->add('layerSeq')
                ->add('titlePosition')
                ->add('mapCenter')
                ->add('titleStyle')
                ->add('type')
                ->add('showScale')
                ->add('shared')
                ->add('enabled')
                ->add('public')
                ->add('createdAt')
                ->add('updatedAt')
                ->add('description')
                ->add('id')
        ;
    }

}
