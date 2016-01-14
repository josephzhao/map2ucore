<?php

namespace Map2u\CoreBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class MapAdmin extends Admin
{
    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
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
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
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
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
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
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
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
