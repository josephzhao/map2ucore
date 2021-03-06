<?php

namespace Map2u\CoreBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class SpatialFileAdmin extends Admin {

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper) {
        $datagridMapper
                ->add('userId')
                ->add('sessionId')
                ->add('fileName')
                ->add('sheetName')
                ->add('public')
                ->add('fileType')
                ->add('supportType')
                ->add('fieldList')
                ->add('selectedFields')
                ->add('description')
                ->add('createdAt')
                ->add('updatedAt')
                ->add('id')
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper) {
        $listMapper
               
                ->add('user')
               
                ->add('fileName')
                ->add('sheetName')
                ->add('public')
                ->add('fileType')
                ->add('supportType')
               
                ->add('selectedFields')
               
               
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
                ->with('Spatial File', array('class' => 'col-md-6'))
                ->add('id', 'hidden')
                ->add('user')
                ->add('fileName')
                ->add('sheetName')
                ->add('public')
                ->add('fileType')
                ->add('supportType')
                ->add('fieldList')
                ->add('selectedFields')
                ->add('description')
                ->end()
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper) {
        $showMapper
                ->add('userId')
                ->add('sessionId')
                ->add('fileName')
                ->add('sheetName')
                ->add('public')
                ->add('fileType')
                ->add('supportType')
                ->add('fieldList')
                ->add('selectedFields')
                ->add('description')
                ->add('createdAt')
                ->add('updatedAt')
                ->add('id')
        ;
    }

}
