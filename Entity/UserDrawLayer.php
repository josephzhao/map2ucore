<?php

namespace Map2u\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;
use Map2u\CoreBundle\Entity\BaseLayer;

/**
 * UserDrawLayer
 */
class UserDrawLayer  extends BaseLayer {

  //  use ORMBehaviors\Translatable\Translatable;

    /**
     * @var guid
     */
    protected $id;

    /**
     * @var integer
     */
    protected $seq;

    /**
     * @var integer
     */
    protected $minZoom;

    /**
     * @var integer
     */
    protected $maxZoom;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var boolean
     */
    protected $public;

    /**
     * @var boolean
     */
    protected $published;

    /**
     * @var boolean
     */
    protected $layerShowInSwitcher;

    /**
     * @var string
     */
    protected $description;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set id
     *
     * @param integer $id
     * @return UserDrawLayer
     */
    public function SetId($id) {
        $this->id = $id;
        return $this;
    }


    /**
     * Set name
     *
     * @param string $name
     * @return UserDrawLayer
     */
    public function setName($name) {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName() {
        return $this->name;
    }

    /**
     * Set published
     *
     * @param boolean $published
     * @return UserDrawLayer
     */
    public function setPublished($published) {
        $this->published = $published;

        return $this;
    }

    /**
     * Get published
     *
     * @return boolean 
     */
    public function getPublished() {
        return $this->published;
    }

    /**
     * Set public
     *
     * @param boolean $public
     * @return UserDrawLayer
     */
    public function setPublic($public) {
        $this->public = $public;

        return $this;
    }

    /**
     * Get published
     *
     * @return boolean 
     */
    public function getPublic() {
        return $this->public;
    }

    /**
     * Set minZoom
     *
     * @param integer $minZoom
     * @return UserDrawLayer
     */
    public function setMinZoom($minZoom) {
        $this->minZoom = $minZoom;

        return $this;
    }

    /**
     * Get minZoom
     *
     * @return integer 
     */
    public function getMinZoom() {
        return $this->minZoom;
    }

    /**
     * Set seq
     *
     * @param integer $maxZoom
     * @return UserDrawLayer
     */
    public function setMaxZoom($maxZoom) {
        $this->maxZoom = $maxZoom;

        return $this;
    }

    /**
     * Get maxZoom
     *
     * @return integer 
     */
    public function getMaxZoom() {
        return $this->maxZoom;
    }

    /**
     * Set layerShowInSwitcher
     *
     * @param boolean $layerShowInSwitcher
     * @return UserDrawLayer
     */
    public function setLayerShowInSwitcher($layerShowInSwitcher) {
        $this->layerShowInSwitcher = $layerShowInSwitcher;

        return $this;
    }

    /**
     * Get layerShowInSwitcher
     *
     * @return boolean 
     */
    public function isLayerShowInSwitcher() {
        return $this->layerShowInSwitcher;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return UserDrawLayer
     */
    public function setDescription($description) {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription() {
        return $this->description;
    }

    /**
     * @var string
     */
    protected $defaultShowOnMap;

    /**
     * Set defaultShowOnMap
     *
     * @param string $defaultShowOnMap
     * @return UserDrawLayer
     */
    public function setDefaultShowOnMap($defaultShowOnMap) {
        $this->defaultShowOnMap = $defaultShowOnMap;

        return $this;
    }

    /**
     * Get defaultShowOnMap
     *
     * @return string 
     */
    public function getDefaultShowOnMap() {
        return $this->defaultShowOnMap;
    }

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    protected $userdrawgeoms;

    /**
     * Constructor
     */
    public function __construct() {
        $this->userdrawgeoms = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add userdrawgeoms
     *
     * @param \Application\Map2u\CoreBundle\Entity\UserDrawGeometries $userdrawgeoms
     * @return UserDrawLayer
     */
    public function addUserdrawgeom(\Application\Map2u\CoreBundle\Entity\UserDrawGeometries $userdrawgeoms) {
        $this->userdrawgeoms[] = $userdrawgeoms;

        return $this;
    }

    /**
     * Remove userdrawgeoms
     *
     * @param \Application\Map2u\CoreBundle\Entity\UserDrawGeometries $userdrawgeoms
     */
    public function removeUserdrawgeom(\Application\Map2u\CoreBundle\Entity\UserDrawGeometries $userdrawgeoms) {
        $this->userdrawgeoms->removeElement($userdrawgeoms);
    }

    /**
     * Get userdrawgeoms
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getUserdrawgeoms() {
        return $this->userdrawgeoms;
    }

    public function __toString() {
        return $this->name;
    }

    /**
     * @var \Map2u\CoreBundle\Entity\Category
     */
    protected $category;


    /**
     * Set seq
     *
     * @param integer $seq
     * @return UserDrawLayer
     */
    public function setSeq($seq)
    {
        $this->seq = $seq;

        return $this;
    }

    /**
     * Get layerShowInSwitcher
     *
     * @return boolean 
     */
    public function getLayerShowInSwitcher()
    {
        return $this->layerShowInSwitcher;
    }

    /**
     * Set category
     *
     * @param \Map2u\CoreBundle\Entity\Category $category
     * @return UserDrawLayer
     */
    public function setCategory(\Map2u\CoreBundle\Entity\Category $category = null)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return \Map2u\CoreBundle\Entity\Category 
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Get seq
     *
     * @return integer 
     */
    public function getSeq()
    {
        return $this->seq;
    }
}
