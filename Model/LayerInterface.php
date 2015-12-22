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

interface LayerInterface {

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
     * Get position
     *
     * @return integer 
     */
    public function getPosition();

    /**
     * Set position
     *
     * @param integer $position
     * @return mixed
     */
    public function setPosition($position);

  

    /**
     * Get type
     *
     * @return integer 
     */
    public function getType();

    /**
     * Set type
     *
     * @param integer $type
     * @return mixed
     */
    public function setType($type);

    /**
     * Set userId
     *
     * @param guid $userId
     * @return mixed
     */
    public function setUserId($userId);

    /**
     * Get userId
     *
     * @return guid 
     */
    public function getUserId();

   

    /**
     * Set name
     *
     * @param string $name
     * @return mixed
     */
    public function setName($name);

    /**
     * Get name
     *
     * @return string 
     */
    public function getName();

    /**
     * Set shared
     *
     * @param boolean $shared
     * @return mixed
     */
    public function setShared($shared);

    /**
     * Get shared
     *
     * @return boolean 
     */
    public function getShared();

//    /**
//     * Set group
//     *
//     * @param \Map2u\CoreBundle\Entity\Group $group
//     * @return mixed
//     */
//    public function setGroup(\Map2u\CoreBundle\Entity\Group $group);
//
//    /**
//     * Get group
//     *
//     * @return \Map2u\CoreBundle\Entity\Group 
//     */
//    public function getGroup();

    /**
     * Set sldFileName
     *
     * @param string $sldFileName
     * @return mixed
     */
    public function setSldFileName($sldFileName);

    /**
     * Get sldFileName
     *
     * @return string 
     */
    public function getSldFileName();

    /**
     * Set sql
     *
     * @param string $sql
     * @return mixed
     */
    public function setSql($sql);

    /**
     * Get sql
     *
     * @return string 
     */
    public function getSql();

    /**
     * Set sessionId
     *
     * @param string $sessionId
     * @return mixed
     */
    public function setSessionId($sessionId);

    /**
     * Get sessionId
     *
     * @return string 
     */
    public function getSessionId();

    /**
     * Set enabled
     *
     * @param boolean $enabled
     * @return mixed
     */
    public function setEnabled($enabled);

    /**
     * Get enabled
     *
     * @return boolean 
     */
    public function isEnabled();

    /**
     * Get enabled
     *
     * @return boolean 
     */
    public function getEnabled();

    /**
     * Set defaultShowOnMap
     *
     * @param boolean $defaultShowOnMap
     * @return mixed
     */
    public function setDefaultShowOnMap($defaultShowOnMap);

    /**
     * Get defaultShowOnMap
     *
     * @return boolean 
     */
    public function isDefaultShowOnMap();

    /**
     * Get defaultShowOnMap
     *
     * @return boolean 
     */
    public function getDefaultShowOnMap();

    /**
     * Set public
     *
     * @param boolean $public
     * @return mixed
     */
    public function setPublic($public);

    /**
     * Get public
     *
     * @return boolean 
     */
    public function isPublic();

    /**
     * Get public
     *
     * @return boolean 
     */
    public function getPublic();

    /**
     * Set layerShowInSwitcher
     *
     * @param boolean $layerShowInSwitcher
     * @return mixed
     */
    public function setLayerShowInSwitcher($layerShowInSwitcher);

    /**
     * Get layerShowInSwitcher
     *
     * @return boolean 
     */
    public function isLayerShowInSwitcher();

    /**
     * Get layerShowInSwitcher
     *
     * @return boolean 
     */
    public function getLayerShowInSwitcher();

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return mixed
     */
    public function setCreatedAt(\DateTime $createdAt);

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
     * @return mixed
     */
    public function setUpdatedAt(\DateTime $updatedAt);

    /**
     * Get updatedAt
     *
     * @return \DateTime 
     */
    public function getUpdatedAt();

    /**
     * Set description
     *
     * @param string $description
     * @return mixed
     */
    public function setDescription($description);

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription();

    /**
     * Set topojson
     *
     * @param boolean $topojson
     * @return mixed
     */
    public function setTopojson($topojson);

    /**
     * Get topojson
     *
     * @return boolean 
     */
    public function isTopojson();

    /**
     * Get topojson
     *
     * @return boolean 
     */
    public function getTopojson();

    /**
     * Set showLabel
     *
     * @param boolean $showLabel
     * @return mixed
     */
    public function setShowLabel($showLabel);

    /**
     * Get showLabel
     *
     * @return boolean 
     */
    public function isShowLabel();

    /**
     * Get showLabel
     *
     * @return boolean 
     */
    public function getShowLabel();

    /**
     * add layergeom
     *
     * @param \Map2u\CoreBundle\Entity\LayerGeom $layergeom
     * @return mixed
     */
    public function addLayerGeom(\Map2u\CoreBundle\Entity\LayerGeom $layergeom = null);

    /**
     * remove layergeom
     *
     * @param \Map2u\CoreBundle\Entity\LayerGeom $layergeom
     * @return mixed
     */
    public function removeLayerGeom(\Map2u\CoreBundle\Entity\LayerGeom $layergeom = null);

    /**
     * Get layergeoms
     *
     * @return  mixed
     */
    public function getLayerGeoms();

    /**
     * add map
     *
     * @param \Map2u\CoreBundle\Entity\Map $map
     * @return mixed
     */
    public function addMap(\Map2u\CoreBundle\Entity\Map $map = null);

    /**
     * remove map
     *
     * @param \Map2u\CoreBundle\Entity\Map $map
     * @return mixed
     */
    public function removeMap(\Map2u\CoreBundle\Entity\Map $map = null);

    /**
     * Get maps
     *
     * @return  mixed
     */
    public function getMaps();

//    /**
//     * add project
//     *
//     * @param \Map2u\CoreBundle\Entity\Project $project
//     * @return mixed
//     */
//    public function addProject(\Map2u\CoreBundle\Entity\Project $project = null);
//
//    /**
//     * remove project
//     *
//     * @param \Map2u\CoreBundle\Entity\Project $project
//     * @return mixed
//     */
//    public function removeProject(\Map2u\CoreBundle\Entity\Project $project = null);

    /**
     * Get projects
     *
     * @return  mixed
     */
    //public function getProjects();
}