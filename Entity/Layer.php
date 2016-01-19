<?php

namespace Map2u\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Map2u\CoreBundle\Entity\BaseLayer;

/**
 * Layer
 */
class Layer extends BaseLayer {

    protected $symbolizedLayers;

    /**
     * Constructor
     */
    public function __construct() {
        parent::__construct();
        $this->symbolizedLayers = new \Doctrine\Common\Collections\ArrayCollection();
    }

        /**
     * Add symbolizedLayers
     *
     * @param \Map2u\CoreBundle\Entity\SymbolizedLayer $symbolizedLayers
     * @return mixed
     */
    public function addSymbolizedLayer(\Map2u\CoreBundle\Entity\SymbolizedLayer $symbolizedLayers) {
        $this->symbolizedLayers[] = $symbolizedLayers;

        return $this;
    }

    /**
     * Remove symbolizedLayers
     *
     * @param \Map2u\CoreBundle\Entity\SymbolizedLayer $symbolizedLayers
     */
    public function removeSymbolizedLayer(\Map2u\CoreBundle\Entity\SymbolizedLayer $symbolizedLayers) {
        $this->symbolizedLayers->removeElement($symbolizedLayers);
    }

    /**
     * Get symbolizedLayers
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getSymbolizedLayers() {
        return $this->symbolizedLayers;
    }
    
//    /**
//     * @var integer
//     */
//    private $id;
//
//    /**
//     * @var integer
//     */
//    private $userId;
//
//    /**
//     * @var string
//     */
//    private $featureName;
//
//    /**
//     * @var string
//     */
//    private $layerName;
//
//    /**
//     * @var string
//     */
//    private $drawType;
//
//    /**
//     * @var string
//     */
//    private $sql;
//
//    /**
//     * @var integer
//     */
//    private $parentId;
//
//    /**
//     * @var array
//     */
//    private $childrenId;
//
//    /**
//     * @var string
//     */
//    private $typeName;
//
//    /**
//     * @var string
//     */
//    private $sessionid;
//
//    /**
//     * @var boolean
//     */
//    private $deleted;
//
//    /**
//     * @var \DateTime
//     */
//    private $createdAt;
//
//    /**
//     * @var \DateTime
//     */
//    private $updatedAt;
//
//    /**
//     * @var string
//     */
//    private $description;
//
//    /**
//     * @var \Doctrine\Common\Collections\Collection
//     */
//    private $projects;
//
//    /**
//     * @var \Doctrine\Common\Collections\Collection
//     */
//    private $tags;
//
//    /**
//     * @var \Doctrine\Common\Collections\Collection
//     */
//    private $categories;
//
//    /**
//     * Constructor
//     */
//    public function __construct() {
//        $this->projects = new \Doctrine\Common\Collections\ArrayCollection();
//        $this->tags = new \Doctrine\Common\Collections\ArrayCollection();
//        $this->categories = new \Doctrine\Common\Collections\ArrayCollection();
//        $this->layergeoms = new \Doctrine\Common\Collections\ArrayCollection();
//    }
//
//    /**
//     * Get id
//     *
//     * @return integer 
//     */
//    public function getId() {
//        return $this->id;
//    }
//
//    /**
//     * Set userId
//     *
//     * @param integer $userId
//     * @return Layer
//     */
//    public function setUserId($userId) {
//        $this->userId = $userId;
//
//        return $this;
//    }
//
//    /**
//     * Get userId
//     *
//     * @return integer 
//     */
//    public function getUserId() {
//        return $this->userId;
//    }
//
//    /**
//     * Set layerName
//     *
//     * @param string $layerName
//     * @return Layer
//     */
//    public function setLayerName($layerName) {
//        $this->layerName = $layerName;
//
//        return $this;
//    }
//
//    /**
//     * Get layerName
//     *
//     * @return string 
//     */
//    public function getLayerName() {
//        return $this->layerName;
//    }
//
//    /**
//     * Set drawType
//     *
//     * @param string $drawType
//     * @return Layer
//     */
//    public function setDrawType($drawType) {
//        $this->drawType = $drawType;
//
//        return $this;
//    }
//
//    /**
//     * Get drawType
//     *
//     * @return string 
//     */
//    public function getdrawType() {
//        return $this->drawType;
//    }
//
//    /**
//     * Set featureName
//     *
//     * @param string $featureName
//     * @return Layer
//     */
//    public function setFeatureName($featureName) {
//        $this->featureName = $featureName;
//
//        return $this;
//    }
//
//    /**
//     * Get featureName
//     *
//     * @return string 
//     */
//    public function getFeatureName() {
//        return $this->featureName;
//    }
//
//    /**
//     * Set sql
//     *
//     * @param string $sql
//     * @return Layer
//     */
//    public function setSql($sql) {
//        $this->sql = $sql;
//
//        return $this;
//    }
//
//    /**
//     * Get sql
//     *
//     * @return string 
//     */
//    public function getSql() {
//        return $this->sql;
//    }
//
//    /**
//     * Set parentId
//     *
//     * @param integer $parentId
//     * @return Layer
//     */
//    public function setParentId($parentId) {
//        $this->parentId = $parentId;
//
//        return $this;
//    }
//
//    /**
//     * Get parentId
//     *
//     * @return integer 
//     */
//    public function getParentId() {
//        return $this->parentId;
//    }
//
//    /**
//     * Set childrenId
//     *
//     * @param array $childrenId
//     * @return Layer
//     */
//    public function setChildrenId($childrenId) {
//        $this->childrenId = $childrenId;
//
//        return $this;
//    }
//
//    /**
//     * Get childrenId
//     *
//     * @return array 
//     */
//    public function getChildrenId() {
//        return $this->childrenId;
//    }
//
//    /**
//     * Set typeName
//     *
//     * @param string $typeName
//     * @return Layer
//     */
//    public function setTypeName($typeName) {
//        $this->typeName = $typeName;
//
//        return $this;
//    }
//
//    /**
//     * Get typeName
//     *
//     * @return string 
//     */
//    public function getTypeName() {
//        return $this->typeName;
//    }
//
//    /**
//     * Set sessionid
//     *
//     * @param string $sessionid
//     * @return Layer
//     */
//    public function setSessionid($sessionid) {
//        $this->sessionid = $sessionid;
//
//        return $this;
//    }
//
//    /**
//     * Get sessionid
//     *
//     * @return string 
//     */
//    public function getSessionid() {
//        return $this->sessionid;
//    }
//
//    /**
//     * Set deleted
//     *
//     * @param boolean $deleted
//     * @return Layer
//     */
//    public function setDeleted($deleted) {
//        $this->deleted = $deleted;
//
//        return $this;
//    }
//
//    /**
//     * Get deleted
//     *
//     * @return boolean 
//     */
//    public function getDeleted() {
//        return $this->deleted;
//    }
//
//    /**
//     * Set createdAt
//     *
//     * @param \DateTime $createdAt
//     * @return Layer
//     */
//    public function setCreatedAt($createdAt) {
//        $this->createdAt = $createdAt;
//
//        return $this;
//    }
//
//    /**
//     * Get createdAt
//     *
//     * @return \DateTime 
//     */
//    public function getCreatedAt() {
//        return $this->createdAt;
//    }
//
//    /**
//     * Set updatedAt
//     *
//     * @param \DateTime $updatedAt
//     * @return Layer
//     */
//    public function setUpdatedAt($updatedAt) {
//        $this->updatedAt = $updatedAt;
//
//        return $this;
//    }
//
//    /**
//     * Get updatedAt
//     *
//     * @return \DateTime 
//     */
//    public function getUpdatedAt() {
//        return $this->updatedAt;
//    }
//
//    /**
//     * Set description
//     *
//     * @param string $description
//     * @return Layer
//     */
//    public function setDescription($description) {
//        $this->description = $description;
//
//        return $this;
//    }
//
//    /**
//     * Get description
//     *
//     * @return string 
//     */
//    public function getDescription() {
//        return $this->description;
//    }
//
//    /**
//     * Add projects
//     *
//     * @param \Map2u\CoreBundle\Entity\Project $projects
//     * @return Layer
//     */
//    public function addProject(\Map2u\CoreBundle\Entity\Project $projects) {
//        $this->projects[] = $projects;
//
//        return $this;
//    }
//
//    /**
//     * Remove projects
//     *
//     * @param \Map2u\CoreBundle\Entity\Project $projects
//     */
//    public function removeProject(\Map2u\CoreBundle\Entity\Project $projects) {
//        $this->projects->removeElement($projects);
//    }
//
//    /**
//     * Get projects
//     *
//     * @return \Doctrine\Common\Collections\Collection 
//     */
//    public function getProjects() {
//        return $this->projects;
//    }
//
//    /**
//     * Add tags
//     *
//     * @param \Map2u\CoreBundle\Entity\ManifoldTag $tags
//     * @return Layer
//     */
//    public function addTag(\Map2u\CoreBundle\Entity\ManifoldTag $tags) {
//        $this->tags[] = $tags;
//
//        return $this;
//    }
//
//    /**
//     * Remove tags
//     *
//     * @param \Map2u\CoreBundle\Entity\ManifoldTag $tags
//     */
//    public function removeTag(\Map2u\CoreBundle\Entity\ManifoldTag $tags) {
//        $this->tags->removeElement($tags);
//    }
//
//    /**
//     * Get tags
//     *
//     * @return \Doctrine\Common\Collections\Collection 
//     */
//    public function getTags() {
//        return $this->tags;
//    }
//
//    /**
//     * Add categories
//     *
//     * @param \Map2u\CoreBundle\Entity\ManifoldCategory $categories
//     * @return Layer
//     */
//    public function addCategory(\Map2u\CoreBundle\Entity\ManifoldCategory $categories) {
//        $this->categories[] = $categories;
//
//        return $this;
//    }
//
//    /**
//     * Remove categories
//     *
//     * @param \Map2u\CoreBundle\Entity\ManifoldCategory $categories
//     */
//    public function removeCategory(\Map2u\CoreBundle\Entity\ManifoldCategory $categories) {
//        $this->categories->removeElement($categories);
//    }
//
//    /**
//     * Get categories
//     *
//     * @return \Doctrine\Common\Collections\Collection 
//     */
//    public function getCategories() {
//        return $this->categories;
//    }
//
//    /**
//     * @var \Doctrine\Common\Collections\Collection
//     */
//    private $layergeoms;
//
//    /**
//     * Add layergeoms
//     *
//     * @param \Map2u\CoreBundle\Entity\LayerGeom $layergeoms
//     * @return Layer
//     */
//    public function addLayergeom(\Map2u\CoreBundle\Entity\LayerGeom $layergeoms) {
//        $this->layergeoms[] = $layergeoms;
//
//        return $this;
//    }
//
//    /**
//     * Remove layergeoms
//     *
//     * @param \Map2u\CoreBundle\Entity\LayerGeom $layergeoms
//     */
//    public function removeLayergeom(\Map2u\CoreBundle\Entity\LayerGeom $layergeoms) {
//        $this->layergeoms->removeElement($layergeoms);
//    }
//
//    /**
//     * Get layergeoms
//     *
//     * @return \Doctrine\Common\Collections\Collection 
//     */
//    public function getLayergeoms() {
//        return $this->layergeoms;
//    }
//
//    /**
//     * @var \Map2u\CoreBundle\Entity\LayerGeom
//     */
//    private $layergeom;
//
//    /**
//     * Set layergeom
//     *
//     * @param \Map2u\CoreBundle\Entity\LayerGeom $layergeom
//     * @return Layer
//     */
//    public function setLayergeom(\Map2u\CoreBundle\Entity\LayerGeom $layergeom = null) {
//        $this->layergeom = $layergeom;
//
//        return $this;
//    }
//
//    /**
//     * Get layergeom
//     *
//     * @return \Map2u\CoreBundle\Entity\LayerGeom 
//     */
//    public function getLayergeom() {
//        return $this->layergeom;
//    }
//
//    /**
//     * @var string
//     */
//    private $layerType;
//
//    /**
//     * Set layerType
//     *
//     * @param string $layerType
//     * @return Layer
//     */
//    public function setLayerType($layerType) {
//        $this->layerType = $layerType;
//
//        return $this;
//    }
//
//    /**
//     * Get layerType
//     *
//     * @return string 
//     */
//    public function getLayerType() {
//        return $this->layerType;
//    }
}
