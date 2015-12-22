<?php

namespace Map2u\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Map2u\CoreBundle\Entity\BaseLayer;

/**
 * LeafletHeatmapLayer
 */
class LeafletHeatmapLayer extends BaseLayer {

    /**
     * @var integer
     */
    protected $userId;

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
     * Set userId
     *
     * @param integer $userId
     * @return LeafletHeatmapLayer
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
     * @return LeafletHeatmapLayer
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
     * @return LeafletHeatmapLayer
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
     * @return LeafletHeatmapLayer
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
     * @return LeafletHeatmapLayer
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
     * @return LeafletHeatmapLayer
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
     * @return LeafletHeatmapLayer
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
     * Set labelField
     *
     * @param string $labelField
     * @return LeafletHeatmapLayer
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
     * @return LeafletHeatmapLayer
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
     * Set defaultShowOnMap
     *
     * @param string $defaultShowOnMap
     * @return LeafletHeatmapLayer
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
     * Set published
     *
     * @param boolean $published
     * @return LeafletHeatmapLayer
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
     * @return LeafletHeatmapLayer
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
     * Set topojsonOnly
     *
     * @param boolean $topojsonOnly
     * @return LeafletHeatmapLayer
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
    public function getTopojsonOnly() {
        return $this->topojsonOnly;
    }

    /**
     * Set layerShowInSwitcher
     *
     * @param boolean $layerShowInSwitcher
     * @return LeafletHeatmapLayer
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
     * Set description
     *
     * @param string $description
     * @return LeafletHeatmapLayer
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
     * Set userUploadfile
     *
     * @param \Map2u\CoreBundle\Entity\UserUploadfile $userUploadfile
     * @return LeafletHeatmapLayer
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
     * @var string
     */
    protected $layerTableName;

    /**
     * @var string
     */
    protected $valueFieldName;

    /**
     * @var string
     */
    protected $contentFields;

    /**
     * Set layerTableName
     *
     * @param string $layerTableName
     * @return LeafletHeatmapLayer
     */
    public function setLayerTableName($layerTableName) {
        $this->layerTableName = $layerTableName;

        return $this;
    }

    /**
     * Get layerTableName
     *
     * @return string 
     */
    public function getLayerTableName() {
        return $this->layerTableName;
    }

    /**
     * Set valueFieldName
     *
     * @param string $valueFieldName
     * @return LeafletHeatmapLayer
     */
    public function setValueFieldName($valueFieldName) {
        $this->valueFieldName = $valueFieldName;

        return $this;
    }

    /**
     * Get valueFieldName
     *
     * @return string 
     */
    public function getValueFieldName() {
        return $this->valueFieldName;
    }

    /**
     * Set contentFields
     *
     * @param string $contentFields
     * @return LeafletHeatmapLayer
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
    protected $gradient;

    /**
     * @var string
     */
    protected $heatmapcategory;

    /**
     * Set datasourceId
     *
     * @param integer $datasourceId
     * @return LeafletHeatmapLayer
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
     * @return LeafletHeatmapLayer
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
     * @return LeafletHeatmapLayer
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
     * Set heatmapcategory
     *
     * @param string $heatmapcategory
     * @return LeafletHeatmapLayer
     */
    public function setHeatmapcategory($heatmapcategory) {
        $this->heatmapcategory = $heatmapcategory;

        return $this;
    }

    /**
     * Get heatmapcategory
     *
     * @return string 
     */
    public function getHeatmapcategory() {
        return $this->heatmapcategory;
    }

    /**
     * @var float
     */
    protected $radius;

    /**
     * @var float
     */
    protected $opacity;

    /**
     * Set radius
     *
     * @param float $radius
     * @return LeafletHeatmapLayer
     */
    public function setRadius($radius) {
        $this->radius = $radius;

        return $this;
    }

    /**
     * Get radius
     *
     * @return float 
     */
    public function getRadius() {
        return $this->radius;
    }

    /**
     * Set opacity
     *
     * @param float $opacity
     * @return LeafletHeatmapLayer
     */
    public function setOpacity($opacity) {
        $this->opacity = $opacity;

        return $this;
    }

    /**
     * Get opacity
     *
     * @return float 
     */
    public function getOpacity() {
        return $this->opacity;
    }

    /**
     * @var \Application\Sonata\UserBundle\Entity\User
     */
    protected $user;

    /**
     * Set user
     *
     * @param \Application\Sonata\UserBundle\Entity\User $user
     * @return LeafletHeatmapLayer
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
     * @return LeafletHeatmapLayer
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
