<?php

/*
 * This file is part of the Sonata project.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Map2u\CoreBundle\Block;

use Sonata\BlockBundle\Block\BlockContextInterface;
use Sonata\CoreBundle\Model\ManagerInterface;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\HttpFoundation\Response;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\CoreBundle\Validator\ErrorElement;
use Sonata\BlockBundle\Model\BlockInterface;
use Sonata\BlockBundle\Block\BaseBlockService;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\ORM\EntityManager;

/**
 *
 * @author     Joseph Zhao jzhao@map2u.com
 */
class UploadSpatialFileBlockService extends BaseBlockService {

    private $em;

    /**
     * @param string             $name
     * @param EngineInterface    $templating
     * @param ContainerInterface $container
     * @param ManagerInterface   $entityManager
     */
    public function __construct($name, EngineInterface $templating, ContainerInterface $container, EntityManager $entityManager) {
        parent::__construct($name, $templating);
        $this->em = $entityManager;
        $this->container = $container;
    }

    /**
     * {@inheritdoc}
     */
    public function execute(BlockContextInterface $blockContext, Response $response = null) {
        $builder = $this->container->get('form.factory')->createBuilder('form');
        $form = $builder
                ->add('categories', 'entity', array(
                    'label' => 'Categories:',
                    'class' => 'Map2uCoreBundle:Category',
                    'required' => false,
                    'property' => 'name'
                ))
                ->add('tags', 'entity', array(
                    'label' => 'Tags:',
                    'class' => 'Map2uCoreBundle:Tag',
                    'required' => false,
                    'property' => 'name'
                ))
                ->add('spatial_file', 'file', array('mapped' => false, 'label' => 'Select upload spatial files:', 'attr' => array("multiple" => "multiple")
                ))
                ->add('upload_file_list', 'choice', array('mapped' => false, 'label' => 'Selected upload files list:', 'attr' => array('size' => "7", "placeholder" => "upload file list!")))
                ->getForm();

//        $form = $this->createForm();
//    $userManager = $this->container->get('fos_user.user_manager');
//    $user = $userManager->findUserByUsername($this->container->get('security.context')
//            ->getToken() ->getUser());
//
//    if ($user && $user != 'anon.') {
//      $shapefilelist = $this->em->createQuery('SELECT u FROM Map2uCoreBundle:SpatialFile u WHERE  u.userId=' . $user->getId() . ' or u.public=true  order by u.updatedAt DESC')
//          ->getResult();
//    }
//    else {
//      $shapefilelist = $this->em->createQuery('SELECT u FROM Map2uCoreBundle:SpatialFile u WHERE  u.public=true  order by u.updatedAt DESC')
//          ->getResult();
//    }

        $parameters = array('context' => $blockContext, 'form' => $form->createView(),
            'settings' => $blockContext->getSettings(),
            'filetypes' => array('1' => array('type' => 'none', 'name' => 'Do not know yet'), '2' => array('type' => 'tradearea', 'name' => 'Trade Area'), '3' => array('type' => 'customer', 'name' => 'Customer'), '4' => array('type' => 'poi', 'name' => 'POI'), '5' => array('type' => 'maps', 'name' => 'Maps')),
            'block' => $blockContext->getBlock()
        );

        if ($blockContext->getSetting('mode') === 'admin') {
            return $this->renderPrivateResponse($blockContext->getTemplate(), $parameters, $response);
        }

        return $this->renderResponse($blockContext->getTemplate(), $parameters, $response);
    }

    /**
     * {@inheritdoc}
     */
    public function validateBlock(ErrorElement $errorElement, BlockInterface $block) {
        // TODO: Implement validateBlock() method.
    }

    /**
     * {@inheritdoc}
     */
    public function buildEditForm(FormMapper $formMapper, BlockInterface $block) {
        $block = '';

        $formMapper->add('settings', 'sonata_type_immutable_array', array(
            'keys' => array(
                array('locale', 'string', array('required' => true)),
                array('title', 'text', array('required' => false)),
                array('usage_title', 'string', array('required' => false)),
                array('mode', 'choice', array(
                        'choices' => array(
                            'public' => 'public',
                            'admin' => 'admin'
                        )
                    )),
                array('type', 'choice', array(
                        'choices' => array(
                            'shapefile' => 'shapefile',
                            'mapinfo' => 'mapinfo',
                            'kmlfile' => 'kmlfile',
                            'textfile' => 'textfile',
                            'excelfile' => 'excelfile'
                        )
                    ))
            )
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getName() {
        return 'Upload Spatial File';
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultSettings(OptionsResolverInterface $resolver) {

        //$form = $this->createFormBuilder();

        $resolver->setDefaults(array(
            'mode' => 'public',
            'title' => 'Upload Spatial Files',
            'type' => 'shapefile',
            'usage_title' => 'Select spatial file usage:',
            'filetypes' => array('1' => array('type' => 'none', 'name' => 'Do not know yet'), '2' => array('type' => 'tradearea', 'name' => 'Trade Area'), '3' => array('type' => 'customer', 'name' => 'Customer'), '4' => array('type' => 'poi', 'name' => 'POI'), '5' => array('type' => 'maps', 'name' => 'Maps')),
            'template' => 'Map2uCoreBundle:Block:uploadspatialfile.html.twig'
        ));
    }

    /*
     * create form
     * return $form
     */

    private function createForm() {
        $builder = $this->container->get('form.factory')->createBuilder('form');
        $form = $builder
                ->add('categories', 'entity', array(
                    'label' => 'Categories:',
                    'class' => 'Map2uCoreBundle:Category',
                    'multiple' => true,
                    'required' => false,
                    'property' => 'name'
                ))
                ->add('tags', 'entity', array(
                    'label' => 'Tags:',
                    'class' => 'Map2uCoreBundle:Tag',
                    'multiple' => true,
                    'required' => false,
                    'property' => 'name'
                ))
                ->add('spatial_file', 'file', array('mapped' => false, 'label' => 'Select Spatial Files:', 'attr' => array("multiple" => "multiple")
                ))
                ->add('upload_file_list', 'choice', array('mapped' => false, 'label' => 'Upload File List:', 'attr' => array('size' => "6", "placeholder" => "upload file list!")))
                ->getForm();
        return $form;
    }

}
