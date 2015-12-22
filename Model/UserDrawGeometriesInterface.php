<?php

namespace Map2u\CoreBundle\Model;

interface UserDrawGeometriesInterface
{


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId();
    

    /**
     * Set userId
     *
     * @param integer $userId
     * @return UserDrawGeometries
     */
    public function setUserId($userId);
   

    /**
     * Get userId
     *
     * @return integer 
     */
    public function getUserId();
   

    /**
     * Set name
     *
     * @param string $name
     * @return UserDrawGeometries
     */
    public function setName($name);
   

    /**
     * Get name
     *
     * @return string 
     */
    public function getName();
   
    /**
     * Set markerIcon
     *
     * @param string $markerIcon
     * @return UserDrawGeometries
     */
    public function setMarkerIcon($markerIcon);
  

    /**
     * Get markerIcon
     *
     * @return string 
     */
    public function getMarkerIcon();
  
    /**
     * Set geomType
     *
     * @param string $geomType
     * @return UserDrawGeometries
     */
    public function setGeomType($geomType);
 

    /**
     * Get geomType
     *
     * @return string 
     */
    public function getGeomType();
    

    /**
     * Set buffer
     *
     * @param float $buffer
     * @return UserDrawGeometries
     */
    public function setBuffer($buffer);
  

    /**
     * Get buffer
     *
     * @return float 
     */
    public function getBuffer();
   

    /**
     * Set public
     *
     * @param boolean $public
     * @return UserDrawGeometries
     */
    public function setPublic($public);
 

    /**
     * Get public
     *
     * @return boolean 
     */
    public function isPublic();
    

    /**
     * Set description
     *
     * @param string $description
     * @return UserDrawGeometries
     */
    public function setDescription($description);
  
    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription();


    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return UserDrawGeometries
     */
    public function setCreatedAt($createdAt);
 

    /**
     * Get createdAt
     *
     * @return \DateTime 
     */
    public function getCreatedAt();
 

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     * @return UserDrawGeometries
     */
    public function setUpdatedAt($updatedAt);


    /**
     * Get updatedAt
     *
     * @return \DateTime 
     */
    public function getUpdatedAt();
  

    /**
     * Set userdrawgeometries_geoms
     *
     * @param \Map2u\CoreBundle\Entity\UserDrawGeometriesGeom $userdrawgeometriesGeoms
     * @return UserDrawGeometries
     */
    public function setUserdrawgeometriesGeoms(\Map2u\CoreBundle\Entity\UserDrawGeometriesGeom $userdrawgeometriesGeoms = null);
    

    /**
     * Get userdrawgeometries_geoms
     *
     * @return \Map2u\CoreBundle\Entity\UserDrawGeometriesGeom 
     */
    public function getUserdrawgeometriesGeoms();
    
    
    /**
     * Set radius
     *
     * @param float $radius
     * @return UserDrawGeometries
     */
    public function setRadius($radius);
 

    /**
     * Get radius
     *
     * @return float 
     */
    public function getRadius();
    
   /**
     * @return string
     */
    public function __toString();
}
