<?php

namespace Map2u\CoreBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class SidebarMenuAdmin extends Admin {

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
                //   ->add('user')
                //      ->add('parent')
                ->add('createdAt')
                ->add('updatedAt')
                //       ->add('description')
                ->add('id')
                ->add('routing')
                ->add('expanded')
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper) {
        $listMapper
                ->add('name')
                ->add('slug')
                ->add('enabled')
                ->add('public')
                ->add('multiple')
                ->add('user')
                ->add('parent')
                ->add('position')
                ->add('updatedAt')
                //     ->add('description')
                ->add('routing')
                ->add('expanded')
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
                ->with('Side Bar Menu', array('class' => 'col-md-6'))
                ->add('id', 'hidden')
                ->add('name')
                ->add('routing')
                ->add('expanded')
                ->add('clickable')
                ->add('slug')
                ->add('position')
                ->add('enabled')
                ->add('public')
                ->add('parent', 'map2u_core_sidebarmenu_selector', array(
                    'user' => $user,
                    'category' => $this->getSubject() ? : null,
                    'model_manager' => $this->getModelManager(),
                    'class' => $this->getClass(),
                    'required' => false
                ))
                ->add('multiple')
                ->end()
                ->with('Side Bar Menu Translation', array('class' => 'col-md-6'))
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
                ->add("user")
                ->add('createdAt')
                ->add('updatedAt')
                //      ->add('description')
                ->add('id')
                ->add('routing')
                ->add('expanded')
        ;
    }

}
