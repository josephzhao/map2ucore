<?php

namespace Map2u\CoreBundle\Entity;


use Sonata\CoreBundle\Model\BaseEntityManager;
use Map2u\CoreBundle\Model\UserDrawGeometriesInterface;
use Map2u\CoreBundle\Model\UserDrawGeometriesManagerInterface;

class GalleryManager extends BaseEntityManager implements UserDrawGeometriesManagerInterface
{
    /**
     * BC Compatibility.
     *
     * @deprecated Please use save() from now
     *
     * @param UserDrawGeometriesInterface $userDrawGeometries
     */
    public function update(UserDrawGeometriesInterface $userDrawGeometries)
    {
        parent::save($userDrawGeometries);
    }
}


