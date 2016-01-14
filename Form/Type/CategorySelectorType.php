<?php

/*
 * This file is part of the Sonata project.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Map2u\CoreBundle\Form\Type;

use Map2u\CoreBundle\Model\CategoryInterface;
use Map2u\CoreBundle\Model\ManagerInterface;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\ChoiceList\SimpleChoiceList;

/**
 * Select a category
 *
 * @author Thomas Rabaix <thomas.rabaix@sonata-project.org>
 */
class CategorySelectorType extends AbstractType {

    protected $manager;

    /**
     * @param ManagerInterface $manager
     */
    public function __construct(ManagerInterface $manager) {
        $this->manager = $manager;
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $that = $this;

        $resolver->setDefaults(array(
            'user' => null,
            'category' => null,
            'choice_list' => function (Options $opts, $previousValue) use ($that) {
                return new SimpleChoiceList($that->getChoices($opts));
            },
            'class' => null
        ));
    }

    /**
     * @param Options $options
     *
     * @return array
     */
    public function getChoices(Options $options) {
        if (!$options['category'] instanceof CategoryInterface) {
            return array();
        }

        $categories = $this->manager->getRootCategories(true);
        var_dump($categories);
        if (!is_array($categories)) {
            $categories = array($categories);
        }
        $choices = array();
        foreach ($categories as $category) {
            if (is_array($category)) {
                foreach ($category as $each_category) {
                    if ($options['category']->getId() === $each_category->getId())
                        continue;
                    if ($each_category->getUser()) {
                        $choices[$each_category->getId()] = sprintf("%s (%s)", $each_category->getName(), $each_category->getUser()->getUserName());
                    } else {
                        $choices[$each_category->getId()] = sprintf("%s (public)", $each_category->getName());
                    }
                    $this->childWalker($each_category, $options, $choices);
                }
            } else {
                if ($options['category']->getId() === $category->getId())
                    continue;
                if ($category->getUser()) {
                    $choices[$category->getId()] = sprintf("%s (%s)", $category->getName(), $category->getUser()->getUserName());
                } else {
                    $choices[$category->getId()] = sprintf("%s (public)", $category->getName());
                }
                $this->childWalker($category, $options, $choices);
            }
        }
        return $choices;
    }

    /**
     * @param CategoryInterface $category
     * @param Options           $options
     * @param array             $choices
     * @param int               $level
     */
    private function childWalker(CategoryInterface $category, Options $options, array &$choices, $level = 2) {
        if ($category->getChildren() === null) {
            return;
        }

        foreach ($category->getChildren() as $child) {
            if ($options['category'] && $options['category']->getId() == $child->getId()) {
                continue;
            }

            $choices[$child->getId()] = sprintf("%s %s", str_repeat('-', 1 * $level), $child);

            $this->childWalker($child, $options, $choices, $level + 1);
        }
    }

    /**
     * {@inheritDoc}
     */
    public function getParent() {
        return 'sonata_type_model';
    }

    /**
     * {@inheritDoc}
     */
    public function getName() {
        return 'map2u_core_category_selector';
    }

}
