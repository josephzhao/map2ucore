<?php

namespace Map2u\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Map2u\CoreBundle\Entity\BaseLayer;



/**
 * ThematicMap
 */
class ThematicMap extends BaseLayer {



    /**
     * @var integer
     */
    protected $userId;

    /**
     * @var integer
     */
    protected $datasourceId;

    /**
     * @var string
     */
    protected $fieldname;

    /**
     * @var string
     */
    protected $defaultSldName;

    /**
     * @var boolean
     */
    protected $layerShowInSwitcher;

    /**
     * @var string
     */
    protected $gradient;

 

    /**
     * @var string
     */
    protected $description;

    /**
     * @var \DateTime
     */
    protected $createdAt;

    /**
     * @var \DateTime
     */
    protected $updatedAt;

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
     * @return ThematicMap
     */
    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    /**
     * Set userId
     *
     * @param integer $userId
     * @return ThematicMap
     */
    public function setUserId($userId) {
        $this->userId = $userId;

        return $this;
    }

    /**
     * Get userId
     *
     * @return integer 
     */
    public function getUserId() {
        return $this->userId;
    }

    /**
     * Set datasourceId
     *
     * @param integer $datasourceId
     * @return ThematicMap
     */
    public function setDatasourceId($datasourceId) {
        $this->datasourceId = $datasourceId;

        return $this;
    }

    /**
     * Get datasourceId
     *
     * @return integer 
     */
    public function getDatasourceId() {
        return $this->datasourceId;
    }

    /**
     * Set fieldname
     *
     * @param string $fieldname
     * @return ThematicMap
     */
    public function setFieldname($fieldname) {
        $this->fieldname = $fieldname;

        return $this;
    }

    /**
     * Get fieldname
     *
     * @return string 
     */
    public function getFieldname() {
        return $this->fieldname;
    }

    /**
     * Set gradient
     *
     * @param string $gradient
     * @return ThematicMap
     */
    public function setGradient($gradient) {
        $this->gradient = $gradient;

        return $this;
    }

    /**
     * Get gradient
     *
     * @return string 
     */
    public function getGradient() {
        return $this->gradient;
    }

 
  
    /**
     * Set description
     *
     * @param string $description
     * @return ThematicMap
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
     * @var boolean
     */
    protected $public;

    /**
     * Set public
     *
     * @param boolean $public
     * @return ThematicMap
     */
    public function setPublic($public) {
        $this->public = $public;

        return $this;
    }

    /**
     * Get public
     *
     * @return boolean 
     */
    public function getPublic() {
        return $this->public;
    }

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
    protected $layerTitle;

    /**
     * @var string
     */
    protected $layerName;

    /**
     * Set seq
     *
     * @param integer $seq
     * @return ThematicMap
     */
    public function setSeq($seq) {
        $this->seq = $seq;

        return $this;
    }

    /**
     * Get seq
     *
     * @return integer 
     */
    public function getSeq() {
        return $this->seq;
    }

    /**
     * Set minZoom
     *
     * @param integer $minZoom
     * @return ThematicMap
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
     * Set maxZoom
     *
     * @param integer $maxZoom
     * @return ThematicMap
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
     * Set layerTitle
     *
     * @param string $layerTitle
     * @return ThematicMap
     */
    public function setLayerTitle($layerTitle) {
        $this->layerTitle = $layerTitle;

        return $this;
    }

    /**
     * Get layerTitle
     *
     * @return string 
     */
    public function getLayerTitle() {
        return $this->layerTitle;
    }

    /**
     * Set layerName
     *
     * @param string $layerName
     * @return ThematicMap
     */
    public function setLayerName($layerName) {
        $this->layerName = $layerName;

        return $this;
    }

    /**
     * Get layerName
     *
     * @return string 
     */
    public function getLayerName() {
        return $this->layerName;
    }

    /**
     * @var boolean
     */
    protected $published;

    /**
     * Set published
     *
     * @param boolean $published
     * @return ThematicMap
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
     * @var string
     */
    protected $defaultShowOnMap;

    /**
     * Set defaultShowOnMap
     *
     * @param string $defaultShowOnMap
     * @return ThematicMap
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
     * @var \Application\Sonata\UserBundle\Entity\User
     */
    protected $user;

    /**
     * Set user
     *
     * @param \Application\Sonata\UserBundle\Entity\User $user
     * @return ThematicMap
     */
    public function setUser(\Application\Sonata\UserBundle\Entity\User $user = null) {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \Application\Sonata\UserBundle\Entity\User 
     */
    public function getUser() {
        return $this->user;
    }

    /**
     * @var boolean
     */
    protected $topojsonOnly;

    /**
     * Set topojsonOnly
     *
     * @param boolean $topojsonOnly
     * @return UploadfileLayer
     */
    public function setTopojsonOnly($topojsonOnly) {
        $this->topojsonOnly = $topojsonOnly;

        return $this;
    }

    /**
     * Get topojsonOnly
     *
     * @return boolean 
     */
    public function isTopojsonOnly() {
        return $this->topojsonOnly;
    }

    /**
     * Set defaultSldName
     *
     * @param string $defaultSldName
     * @return ThematicMap
     */
    public function setDefaultSldName($defaultSldName) {
        $this->defaultSldName = $defaultSldName;

        return $this;
    }

    /**
     * Get defaultSldName
     *
     * @return string 
     */
    public function getDefaultSldName() {
        return $this->defaultSldName;
    }

    /**
     * Set layerShowInSwitcher
     *
     * @param boolean $layerShowInSwitcher
     * @return ThematicMap
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
    public function getLayerShowInSwitcher() {
        return $this->layerShowInSwitcher;
    }

    /**
     * Get topojsonOnly
     *
     * @return boolean 
     */
    public function getTopojsonOnly() {
        return $this->topojsonOnly;
    }

    /**
     * @var \Map2u\CoreBundle\Entity\Category
     */
    protected $category;


    /**
     * Set category
     *
     * @param \Map2u\CoreBundle\Entity\Category $category
     * @return ThematicMap
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
}
