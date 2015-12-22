<?php

namespace Map2u\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UserDrawGeometriesGeom
 */
class UserDrawGeometriesGeom
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var geometry
     */
    private $theGeom;

    /**
     * @var \Map2u\CoreBundle\Entity\UserDrawGeometries
     */
    private $userdrawgeometries;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set theGeom
     *
     * @param geometry $theGeom
     * @return UserDrawGeometriesGeom
     */
    public function setTheGeom($theGeom)
    {
        $this->theGeom = $theGeom;

        return $this;
    }

    /**
     * Get theGeom
     *
     * @return geometry 
     */
    public function getTheGeom()
    {
        return $this->theGeom;
    }

    /**
     * Set userdrawgeometries
     *
     * @param Application\Map2u\CoreBundle\Entity\UserDrawGeometries $userdrawgeometries
     * @return UserDrawGeometriesGeom
     */
    public function setUserdrawgeometries(\Application\Map2u\CoreBundle\Entity\UserDrawGeometries $userdrawgeometries = null)
    {
        $this->userdrawgeometries = $userdrawgeometries;

        return $this;
    }

    /**
     * Get userdrawgeometries
     *
     * @return Application\Map2u\CoreBundle\Entity\UserDrawGeometries 
     */
    public function getUserdrawgeometries()
    {
        return $this->userdrawgeometries;
    }
}
