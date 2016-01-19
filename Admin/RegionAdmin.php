<?php

namespace Map2u\CoreBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class RegionAdmin extends Admin {

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper) {
        $datagridMapper
                ->add('id')
                ->add('countryId')
                ->add('lng')
                ->add('lat')
                ->add('zoomLevel')
                ->add('cityId')
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper) {
        $listMapper
                ->add('id')
                ->add('countryId')
                ->add('lng')
                ->add('lat')
                ->add('zoomLevel')
                ->add('cityId')
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
                ->with('Region', array('class' => 'col-md-6'))
                ->add('id', 'hidden')
                ->add('translations', 'a2lix_translations', array(
                    'by_reference' => false,
                    'required' => false))
                ->add('countryId')
                ->add('cityId')
                ->add('lng')
                ->add('lat')
                ->add('zoomLevel')
                ->end()
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper) {
        $showMapper
                ->add('id')
                ->add('countryId')
                ->add('lng')
                ->add('lat')
                ->add('zoomLevel')
                ->add('cityId')
        ;
    }

}
