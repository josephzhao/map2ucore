<?php

/*
 * This file is part of the FOSUserBundle package.
 *
 * (c) FriendsOfSymfony <http://friendsofsymfony.github.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Map2u\CoreBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\Extension\Core\View\ChoiceView;

class SidebarMenuTreeType extends AbstractType {

    public function buildView(FormView $view, FormInterface $form, array $options) {

        $choices = [];

        foreach ($view->vars['choices'] as $choice) {
            $choices[] = $choice->data;
        }

        $choices = $this->buildTreeChoices($choices);

        $view->vars['choices'] = $choices;
    }

    protected function buildTreeChoices($choices, $level = 0) {

        $result = array();

        foreach ($choices as $choice) {
            $choice->setLevel($level);
            $result[] = new ChoiceView(
                    str_repeat('-', $level) . ' ' . ucwords($choice->getTitle()), $choice->getId(), $choice, []
            );

            if (!$choice->getChildren()->isEmpty())
                $result = array_merge(
                        $result, $this->buildTreeChoices($choice->getChildren(), $level + 1)
                );
        }

        return $result;
    }



    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'query_builder' => function ( EntityRepository $repo ) {
                return $repo->createQueryBuilder('e')->where('e.parentId IS NULL');
            }
        ));
    }

    public function getParent() {
        return 'entity';
    }

    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName() {
        return 'entity_sidebar_menu';
    }

}
