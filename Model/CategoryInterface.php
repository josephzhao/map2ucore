<?php

/*
 * This file is part of the Sonata project.
 *
 * (c) Sonata Project <https://github.com/sonata-project/SonataClassificationBundle/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Map2u\CoreBundle\Model;

use Application\Sonata\UserBundle\Entity\User;

interface CategoryInterface {

    /**
     * Get id
     *
     * @return guid 
     */
    public function getId();

    /**
     * Set id
     *
     * @param guid $id
     * @return mixed
     */
    public function setId($id);

    /**
     * @param boolean $multiple
     */
    public function setMultiple($multiple);

    /**
     * @return boolean
     */
    public function getMultiple();

    /**
     * @param $name
     *
     * @return mixed
     */
    public function setName($name);

    /**
     * Get name
     *
     * @return string $name
     */
    public function getName();

    /**
     * @param $title
     *
     * @return mixed
     */
    public function setTitle($title);

    /**
     * Get title
     *
     * @return string $title
     */
    public function getTitle();

    /**
     * Set enabled
     *
     * @param boolean $enabled
     */
    public function setEnabled($enabled);

    /**
     * Get enabled
     *
     * @return boolean $enabled
     */
    public function getEnabled();

    /**
     * Set public
     *
     * @param boolean $public
     */
    public function setPublic($public);

    /**
     * Get public
     *
     * @return boolean $public
     */
    public function getPublic();

    /**
     * Set slug
     *
     * @param integer $slug
     */
    public function setSlug($slug);

    /**
     * Get slug
     *
     * @return integer $slug
     */
    public function getSlug();

    /**
     * Set description
     *
     * @param string $description
     */
    public function setDescription($description);

    /**
     * Get description
     *
     * @return string $description
     */
    public function getDescription();

    /**
     * @param integer $position
     */
    public function setPosition($position);

    /**
     * @return integer
     */
    public function getPosition();

    /**
     * Add Children
     *
     * @param CategoryInterface $children
     * @param boolean           $nested
     */
    public function addChild(CategoryInterface $children, $nested = false);

    /**
     * Get Children
     *
     * @return \Doctrine\Common\Collections\Collection $children
     */
    public function getChildren();

    /**
     * Set children
     *
     * @param $children
     */
    public function setChildren($children);

    /**
     * Return true if category has children
     *
     * @return boolean
     */
    public function hasChildren();

    /**
     * Set Parent
     *
     * @param CategoryInterface $parent
     * @param boolean           $nested
     */
    public function setParent(CategoryInterface $parent = null, $nested = false);

    /**
     * Get Parent
     *
     * @return CategoryInterface $parent
     */
    public function getParent();

    /**
     * Get user
     *
     * @return User $user
     */
    public function getUser();

    /**
     * Set user
     *
     * @param User $user
     */
    public function setUser(User $user = null);
}
