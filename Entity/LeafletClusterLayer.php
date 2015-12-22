<?php

namespace Map2u\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Map2u\CoreBundle\Entity\BaseLayer;

/**
 * LeafletClusterLayer
 */
class LeafletClusterLayer extends BaseLayer {

    /**
     * @var string
     */
    protected $layerName;

    /**
     * @var string
     */
    protected $labelField;

    /**
     * @var string
     */
    protected $tipField;

    /**
     * @var boolean
     */
    protected $topojsonOnly;

    /**
     * @var boolean
     */
    protected $layerShowInSwitcher;

    /**
     * @var \Map2u\CoreBundle\Entity\SpatialFile
     */
    protected $spatialfile;

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
     * @return LeafletClusterLayer
     */
    public function setId($id) {
        $this->id = $id;

        return $this;
    }

    /**
     * Set userId
     *
     * @param integer $userId
     * @return LeafletClusterLayer
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
     * @return LeafletClusterLayer
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
     * @return LeafletClusterLayer
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
     * @return LeafletClusterLayer
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
     * @return LeafletClusterLayer
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
     * @return LeafletClusterLayer
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
     * @return LeafletClusterLayer
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
     * @return LeafletClusterLayer
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
     * @return LeafletClusterLayer
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
     * @return LeafletClusterLayer
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
     * Set published
     *
     * @param boolean $published
     * @return LeafletClusterLayer
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
     * Set public
     *
     * @param boolean $public
     * @return LeafletClusterLayer
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
     * Set topojsonOnly
     *
     * @param boolean $topojsonOnly
     * @return LeafletClusterLayer
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
     * Set layerShowInSwitcher
     *
     * @param boolean $layerShowInSwitcher
     * @return LeafletClusterLayer
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
     * Set spatialfile
     *
     * @param \Map2u\CoreBundle\Entity\SpatialFile $spatialfile
     * @return LeafletClusterLayer
     */
    public function setSpatialFile(\Map2u\CoreBundle\Entity\SpatialFile $spatialfile = null) {
        $this->spatialfile = $spatialfile;

        return $this;
    }

    /**
     * Get spatialfile
     *
     * @return \Map2u\CoreBundle\Entity\SpatialFile 
     */
    public function getSpatialFile() {
        return $this->spatialfile;
    }

    /**
     * @var boolean
     */
    private $showCoverageOnHover;

    /**
     * @var boolean
     */
    private $zoomToBoundsOnClick;

    /**
     * @var boolean
     */
    private $spiderfyOnMaxZoom;

    /**
     * @var boolean
     */
    private $removeOutsideVisibleBounds;

    /**
     * @var boolean
     */
    private $animateAddingMarkers;

    /**
     * @var integer
     */
    private $disableClusteringAtZoom;

    /**
     * @var integer
     */
    private $maxClusterRadius;

    /**
     * @var string
     */
    private $polygonOptions;

    /**
     * @var boolean
     */
    private $singleMarkerMode;

    /**
     * @var integer
     */
    private $spiderfyDistanceMultiplier;

    /**
     * @var string
     */
    private $iconCreateFunction;

    /**
     * Set showCoverageOnHover
     *
     * @param boolean $showCoverageOnHover
     * @return LeafletClusterLayer
     */
    public function setShowCoverageOnHover($showCoverageOnHover) {
        $this->showCoverageOnHover = $showCoverageOnHover;

        return $this;
    }

    /**
     * Get showCoverageOnHover
     *
     * @return boolean 
     */
    public function getShowCoverageOnHover() {
        return $this->showCoverageOnHover;
    }

    /**
     * Set zoomToBoundsOnClick
     *
     * @param boolean $zoomToBoundsOnClick
     * @return LeafletClusterLayer
     */
    public function setZoomToBoundsOnClick($zoomToBoundsOnClick) {
        $this->zoomToBoundsOnClick = $zoomToBoundsOnClick;

        return $this;
    }

    /**
     * Get zoomToBoundsOnClick
     *
     * @return boolean 
     */
    public function getZoomToBoundsOnClick() {
        return $this->zoomToBoundsOnClick;
    }

    /**
     * Set spiderfyOnMaxZoom
     *
     * @param boolean $spiderfyOnMaxZoom
     * @return LeafletClusterLayer
     */
    public function setSpiderfyOnMaxZoom($spiderfyOnMaxZoom) {
        $this->spiderfyOnMaxZoom = $spiderfyOnMaxZoom;

        return $this;
    }

    /**
     * Get spiderfyOnMaxZoom
     *
     * @return boolean 
     */
    public function getSpiderfyOnMaxZoom() {
        return $this->spiderfyOnMaxZoom;
    }

    /**
     * Set removeOutsideVisibleBounds
     *
     * @param boolean $removeOutsideVisibleBounds
     * @return LeafletClusterLayer
     */
    public function setRemoveOutsideVisibleBounds($removeOutsideVisibleBounds) {
        $this->removeOutsideVisibleBounds = $removeOutsideVisibleBounds;

        return $this;
    }

    /**
     * Get removeOutsideVisibleBounds
     *
     * @return boolean 
     */
    public function getRemoveOutsideVisibleBounds() {
        return $this->removeOutsideVisibleBounds;
    }

    /**
     * Set animateAddingMarkers
     *
     * @param boolean $animateAddingMarkers
     * @return LeafletClusterLayer
     */
    public function setAnimateAddingMarkers($animateAddingMarkers) {
        $this->animateAddingMarkers = $animateAddingMarkers;

        return $this;
    }

    /**
     * Get animateAddingMarkers
     *
     * @return boolean 
     */
    public function getAnimateAddingMarkers() {
        return $this->animateAddingMarkers;
    }

    /**
     * Set disableClusteringAtZoom
     *
     * @param integer $disableClusteringAtZoom
     * @return LeafletClusterLayer
     */
    public function setDisableClusteringAtZoom($disableClusteringAtZoom) {
        $this->disableClusteringAtZoom = $disableClusteringAtZoom;

        return $this;
    }

    /**
     * Get disableClusteringAtZoom
     *
     * @return integer 
     */
    public function getDisableClusteringAtZoom() {
        return $this->disableClusteringAtZoom;
    }

    /**
     * Set maxClusterRadius
     *
     * @param integer $maxClusterRadius
     * @return LeafletClusterLayer
     */
    public function setMaxClusterRadius($maxClusterRadius) {
        $this->maxClusterRadius = $maxClusterRadius;

        return $this;
    }

    /**
     * Get maxClusterRadius
     *
     * @return integer 
     */
    public function getMaxClusterRadius() {
        return $this->maxClusterRadius;
    }

    /**
     * Set polygonOptions
     *
     * @param string $polygonOptions
     * @return LeafletClusterLayer
     */
    public function setPolygonOptions($polygonOptions) {
        $this->polygonOptions = $polygonOptions;

        return $this;
    }

    /**
     * Get polygonOptions
     *
     * @return string 
     */
    public function getPolygonOptions() {
        return $this->polygonOptions;
    }

    /**
     * Set singleMarkerMode
     *
     * @param boolean $singleMarkerMode
     * @return LeafletClusterLayer
     */
    public function setSingleMarkerMode($singleMarkerMode) {
        $this->singleMarkerMode = $singleMarkerMode;

        return $this;
    }

    /**
     * Get singleMarkerMode
     *
     * @return boolean 
     */
    public function getSingleMarkerMode() {
        return $this->singleMarkerMode;
    }

    /**
     * Set spiderfyDistanceMultiplier
     *
     * @param integer $spiderfyDistanceMultiplier
     * @return LeafletClusterLayer
     */
    public function setSpiderfyDistanceMultiplier($spiderfyDistanceMultiplier) {
        $this->spiderfyDistanceMultiplier = $spiderfyDistanceMultiplier;

        return $this;
    }

    /**
     * Get spiderfyDistanceMultiplier
     *
     * @return integer 
     */
    public function getSpiderfyDistanceMultiplier() {
        return $this->spiderfyDistanceMultiplier;
    }

    /**
     * Set iconCreateFunction
     *
     * @param string $iconCreateFunction
     * @return LeafletClusterLayer
     */
    public function setIconCreateFunction($iconCreateFunction) {
        $this->iconCreateFunction = $iconCreateFunction;

        return $this;
    }

    /**
     * Get iconCreateFunction
     *
     * @return string 
     */
    public function getIconCreateFunction() {
        return $this->iconCreateFunction;
    }

    /**
     * @var \Application\Sonata\UserBundle\Entity\User
     */
    protected $user;

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
     * Get layerShowInSwitcher
     *
     * @return boolean 
     */
    public function getLayerShowInSwitcher() {
        return $this->layerShowInSwitcher;
    }

    /**
     * Set user
     *
     * @param \Application\Sonata\UserBundle\Entity\User $user
     * @return LeafletClusterLayer
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
     * @return LeafletClusterLayer
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
