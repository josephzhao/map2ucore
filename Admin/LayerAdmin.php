<?php

namespace Map2u\CoreBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class LayerAdmin extends Admin
{
    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
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
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
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
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
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
}
