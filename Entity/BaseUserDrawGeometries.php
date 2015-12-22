<?php

namespace Map2u\CoreBundle\Entity;

use Map2u\CoreBundle\Model\UserDrawGeometries as abstractDrawGeometries;

abstract class BaseUserDrawGeometries extends abstractDrawGeometries {

    
    /**
     * {@inheritdoc}
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * Pre Persist method
     */
    public function prePersist() {
        $this->createdAt = new \DateTime();
        $this->updatedAt = new \DateTime();
    }

    /**
     * Pre Update method
     */
    public function preUpdate() {
        $this->updatedAt = new \DateTime();
    }

    /**
     * @var integer
     */
    protected $id;

    /**
     * @var integer
     */
    protected $userId;

    /**
     * @var integer
     */
    protected $userdrawlayerId;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $geomType;

    /**
     * @var string
     */
    protected $radius;

    /**
     * @var string
     */
    protected $buffer;

    /**
     * @var string
     */
    protected $markerIcon;

    /**
     * @var boolean
     */
    protected $public;

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
     * @var \Map2u\CoreBundle\Entity\UserDrawGeometriesGeom
     */
    protected $userdrawgeometries_geoms;

    /**
     * @var \Application\Sonata\UserBundle\Entity\User
     */
    private $user;

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
     * @return BaseUserDrawGeometries
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
     * Set userdrawlayerId
     *
     * @param integer $userdrawlayerId
     * @return BaseUserDrawGeometries
     */
    public function setUserdrawlayerId($userdrawlayerId) {
        $this->userdrawlayerId = $userdrawlayerId;

        return $this;
    }

    /**
     * Get userdrawlayerId
     *
     * @return integer 
     */
    public function getUserdrawlayerId() {
        return $this->userdrawlayerId;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return BaseUserDrawGeometries
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
     * Set geomType
     *
     * @param string $geomType
     * @return BaseUserDrawGeometries
     */
    public function setGeomType($geomType) {
        $this->geomType = $geomType;

        return $this;
    }

    /**
     * Get geomType
     *
     * @return string 
     */
    public function getGeomType() {
        return $this->geomType;
    }

    /**
     * Set radius
     *
     * @param string $radius
     * @return BaseUserDrawGeometries
     */
    public function setRadius($radius) {
        $this->radius = $radius;

        return $this;
    }

    /**
     * Get radius
     *
     * @return string 
     */
    public function getRadius() {
        return $this->radius;
    }

    /**
     * Set buffer
     *
     * @param string $buffer
     * @return BaseUserDrawGeometries
     */
    public function setBuffer($buffer) {
        $this->buffer = $buffer;

        return $this;
    }

    /**
     * Get buffer
     *
     * @return string 
     */
    public function getBuffer() {
        return $this->buffer;
    }

    /**
     * Set markerIcon
     *
     * @param string $markerIcon
     * @return BaseUserDrawGeometries
     */
    public function setMarkerIcon($markerIcon) {
        $this->markerIcon = $markerIcon;

        return $this;
    }

    /**
     * Get markerIcon
     *
     * @return string 
     */
    public function getMarkerIcon() {
        return $this->markerIcon;
    }

    /**
     * Set public
     *
     * @param boolean $public
     * @return BaseUserDrawGeometries
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
     * Set description
     *
     * @param string $description
     * @return BaseUserDrawGeometries
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
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return BaseUserDrawGeometries
     */
    public function setCreatedAt($createdAt) {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime 
     */
    public function getCreatedAt() {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     * @return BaseUserDrawGeometries
     */
    public function setUpdatedAt($updatedAt) {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime 
     */
    public function getUpdatedAt() {
        return $this->updatedAt;
    }

    /**
     * Set userdrawgeometries_geoms
     *
     * @param \Map2u\CoreBundle\Entity\UserDrawGeometriesGeom $userdrawgeometriesGeoms
     * @return BaseUserDrawGeometries
     */
    public function setUserdrawgeometriesGeoms(\Map2u\CoreBundle\Entity\UserDrawGeometriesGeom $userdrawgeometriesGeoms = null) {
        $this->userdrawgeometries_geoms = $userdrawgeometriesGeoms;

        return $this;
    }

    /**
     * Get userdrawgeometries_geoms
     *
     * @return \Map2u\CoreBundle\Entity\UserDrawGeometriesGeom 
     */
    public function getUserdrawgeometriesGeoms() {
        return $this->userdrawgeometries_geoms;
    }

    /**
     * Set user
     *
     * @param \Application\Sonata\UserBundle\Entity\User $user
     * @return BaseUserDrawGeometries
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
     * @var \Map2u\CoreBundle\Entity\UserDrawLayer
     */
    private $userdrawlayer;

    /**
     * Set userdrawlayer
     *
     * @param \Map2u\CoreBundle\Entity\UserDrawLayer $userdrawlayer
     * @return BaseUserDrawGeometries
     */
    public function setUserdrawlayer(\Map2u\CoreBundle\Entity\UserDrawLayer $userdrawlayer = null) {
        $this->userdrawlayer = $userdrawlayer;

        return $this;
    }

    /**
     * Get userdrawlayer
     *
     * @return \Map2u\CoreBundle\Entity\UserDrawLayer 
     */
    public function getUserdrawlayer() {
        return $this->userdrawlayer;
    }

}
