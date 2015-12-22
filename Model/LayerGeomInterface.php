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

interface LayerGeomInterface {

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
     * Set tableId
     *
     * @param guid $tableId
     * @return mixed
     */
    public function setTableId($tableId);

    /**
     * Get tableId
     *
     * @return guid 
     */
    public function getTableId();

    /**
     * Set rowId
     *
     * @param guid $rowId
     * @return mixed
     */
    public function setRowId($rowId);

    /**
     * Get rowId
     *
     * @return guid 
     */
    public function getRowId();

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
     * Set value
     *
     * @param mixed $value
     * @return mixed
     */
    public function setValue($value);

    /**
     * Get value
     *
     * @return mixed 
     */
    public function getValue();

    /**
     * Set theGeom
     *
     * @param geometry $theGeom
     * @return mixed
     */
    public function setTheGeom($theGeom);

    /**
     * Get theGeom
     *
     * @return geometry 
     */
    public function getTheGeom();

    /**
     * Get layer
     *
     * @return mixed 
     */
    public function getLayer();

    /**
     * Get theGeomType
     *
     * @return string 
     */
    public function getTheGeomType();
}