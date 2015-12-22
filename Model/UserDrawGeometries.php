<?php

namespace Map2u\CoreBundle\Model;

abstract class UserDrawGeometries implements UserDrawGeometriesInterface {

    /**
     * @var integer
     */
    protected $id;

    /**
     * @var integer
     */
    protected $userId;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $markerIcon;

    /**
     * @var string
     */
    protected $geomType;

    /**
     * @var float
     */
    protected $buffer;

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
     * Get id
     *
     * @return integer 
     */
    public function getId() {
        return $this->id;
    }

    /**
     * set id
     *
     *   @param integer $userId
     * @return UserDrawGeometries 
     */
    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    /**
     * Set userId
     *
     * @param integer $userId
     * @return UserDrawGeometries
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
     * Set name
     *
     * @param string $name
     * @return UserDrawGeometries
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
     * Set markerIcon
     *
     * @param string $markerIcon
     * @return UserDrawGeometries
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
     * Set geomType
     *
     * @param string $geomType
     * @return UserDrawGeometries
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
     * Set buffer
     *
     * @param float $buffer
     * @return UserDrawGeometries
     */
    public function setBuffer($buffer) {
        $this->buffer = $buffer;

        return $this;
    }

    /**
     * Get buffer
     *
     * @return float 
     */
    public function getBuffer() {
        return $this->buffer;
    }

    /**
     * Set public
     *
     * @param boolean $public
     * @return UserDrawGeometries
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
     * Set description
     *
     * @param string $description
     * @return UserDrawGeometries
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
     * @return UserDrawGeometries
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
     * @return UserDrawGeometries
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
     * @return UserDrawGeometries
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
     * @var float
     */
    protected $radius;

    /**
     * Set radius
     *
     * @param float $radius
     * @return UserDrawGeometries
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

}
