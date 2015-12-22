<?php

namespace Map2u\CoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SpatialFileType extends AbstractType {

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
        ->add('id', 'hidden')
        ->add('categories', 'entity', array(
        'label' => 'Categories:',
        'class' => 'Map2u\CoreBundle\Entity\Category',
        'multiple' => true,
        'property' => 'name'
        ))
        ->add('tags', 'entity', array(
        'label' => 'Tags:',
        'class' => 'Map2uCoreBundle:Tag',
        'multiple' => true,
        'property' => 'name'))
        ->add('spatial_file', 'file', array('mapped'=>false,'attr' => array('multiple' => true)))
        ->add('description', 'textarea', array('label' => 'Description:', 'attr' => array("placeholder" => "Input project description!", "style" => "width:100%")
        ))
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Map2u\CoreBundle\Entity\SpatialFile'
        ));
    }

    /**
     * @return string
     */
    public function getName() {
        return 'map2u_corebundle_spatialfile';
    }

}
