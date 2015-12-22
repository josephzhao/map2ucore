<?php

/*
 * This file is part of the Sonata project.
 *
 * (c) Sonata Project <https://github.com/sonata-project/SonataClassificationBundle/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Map2u\CoreBundle\Entity;

use Map2u\CoreBundle\Entity\BaseGroup;

class UserGroup extends BaseGroup {

    protected $maplayers;
    protected $id;
    protected $groupAdmin;
    
    /**
     * Add maplayer
     *
     * @param \Map2u\CoreBundle\Model\MapLayerInterface $maplayer
     * @return mixed
     */
    public function addMapLayer(\Map2u\CoreBundle\Model\MapLayerInterface $maplayer) {
        $this->maplayers[] = $maplayer;

        return $this;
    }

    /**
     * Remove maplayer
     *
     * @param \Map2u\CoreBundle\Model\MapLayerInterface $maplayer
     */
    public function removeMapLayer(\Map2u\CoreBundle\Model\MapLayerInterface $maplayer) {
        $this->maplayers->removeElement($maplayer);
    }

    /**
     * Get maplayers
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getMapLayers() {
        return $this->maplayers;
    }

}
