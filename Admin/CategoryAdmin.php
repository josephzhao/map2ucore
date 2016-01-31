<?php

namespace Map2u\CoreBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class CategoryAdmin extends Admin {

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper) {
        $datagridMapper
                ->add('position')
                ->add('name')
                ->add('slug')
                ->add('enabled')
                ->add('public')
                ->add('multiple')
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
                ->add('name')
                ->add('position')
                ->add('slug')
                ->add('enabled')
                ->add('public')
                ->add('multiple')
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
        $user = $this->getConfigurationPool()->getContainer()->get('security.context')->getToken()->getUser();
        $formMapper
                ->with('Category', array('class' => 'col-md-6'))
                ->add('id', 'hidden')
                ->add('user')
                ->add('name')
                ->add('multiple')
                ->add('position')
                ->add('enabled')
                ->add('public')
                ->add('slug')
                ->add('parent', 'map2u_core_category_selector', array(
                    'user' => $user,
                    'category' => $this->getSubject() ? : null,
                    'model_manager' => $this->getModelManager(),
                    'class' => $this->getClass(),
                    'required' => false
                ))
                ->end()
                ->with('Category Translation', array('class' => 'col-md-6'))
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
                ->add('position')
                ->add('name')
                ->add('slug')
                ->add('enabled')
                ->add('public')
                ->add('multiple')
                ->add('createdAt')
                ->add('updatedAt')
                ->add('id')
        ;
    }

}
