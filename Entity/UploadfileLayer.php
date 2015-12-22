<?php

namespace Map2u\CoreBundle\Entity;
use Map2u\CoreBundle\Entity\BaseLayer;




/**
 * UploadfileLayer
 */
class UploadfileLayer extends BaseLayer {


    /**
     * @var \Map2u\CoreBundle\Entity\UserUploadfile
     */
    protected $userUploadfile;

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
     * @return UploadfileLayer
     */
    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    /**
     * Set userId
     *
     * @param integer $userId
     * @return UploadfileLayer
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
     * Set seq
     *
     * @param integer $seq
     * @return UploadfileLayer
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
     * @return UploadfileLayer
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
     * @return UploadfileLayer
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
     * @return UploadfileLayer
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
     * Set labelField
     *
     * @param string $labelField
     * @return UserUploadfile
     */
    public function setLabelField($labelField) {
        $this->labelField = $labelField;

        return $this;
    }

    /**
     * Get labelField
     *
     * @return string 
     */
    public function getLabelField() {
        return $this->labelField;
    }

    /**
     * Set tipField
     *
     * @param string $tipField
     * @return UserUploadfile
     */
    public function setTipField($tipField) {
        $this->tipField = $tipField;

        return $this;
    }

    /**
     * Get tipField
     *
     * @return string 
     */
    public function getTipField() {
        return $this->tipField;
    }

    /**
     * Set layerName
     *
     * @param string $layerName
     * @return UploadfileLayer
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
     * Set defaultSldName
     *
     * @param string $defaultSldName
     * @return UploadfileLayer
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
     * Set published
     *
     * @param boolean $published
     * @return UploadfileLayer
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
    public function isPublished() {
        return $this->published;
    }

    /**
     * Set defaultShowOnMap
     *
     * @param string $defaultShowOnMap
     * @return UploadfileLayer
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
    public function isDefaultShowOnMap() {
        return $this->defaultShowOnMap;
    }

    /**
     * Set public
     *
     * @param boolean $public
     * @return UploadfileLayer
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
    public function isPublic() {
        return $this->public;
    }

    /**
     * Set layerShowInSwitcher
     *
     * @param boolean $layerShowInSwitcher
     * @return UploadfileLayer
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
     * Set userUploadfile
     *
     * @param \Map2u\CoreBundle\Entity\UserUploadfile $userUploadfile
     * @return UploadfileLayer
     */
    public function setUserUploadfile(\Map2u\CoreBundle\Entity\UserUploadfile $userUploadfile = null) {
        $this->userUploadfile = $userUploadfile;

        return $this;
    }

    /**
     * Get userUploadfile
     *
     * @return \Map2u\CoreBundle\Entity\UserUploadfile 
     */
    public function getUserUploadfile() {
        return $this->userUploadfile;
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
     * @var string
     */
    protected $contentFields;

    /**
     * Get defaultShowOnMap
     *
     * @return boolean 
     */
    public function getDefaultShowOnMap() {
        return $this->defaultShowOnMap;
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
     * Get public
     *
     * @return boolean 
     */
    public function getPublic() {
        return $this->public;
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
     * Set contentFields
     *
     * @param string $contentFields
     * @return UploadfileLayer
     */
    public function setContentFields($contentFields) {
        $this->contentFields = $contentFields;

        return $this;
    }

    /**
     * Get contentFields
     *
     * @return string 
     */
    public function getContentFields() {
        return $this->contentFields;
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
     * @var \Application\Sonata\UserBundle\Entity\User
     */
    protected $user;

    /**
     * Set user
     *
     * @param \Application\Sonata\UserBundle\Entity\User $user
     * @return UploadfileLayer
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
     * @var \Map2u\CoreBundle\Entity\Category
     */
    protected $category;

    /**
     * Set category
     *
     * @param \Map2u\CoreBundle\Entity\Category $category
     * @return UploadfileLayer
     */
    public function setCategory(\Map2u\CoreBundle\Entity\Category $category = null) {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return \Map2u\CoreBundle\Entity\Category 
     */
    public function getCategory() {
        return $this->category;
    }

}
