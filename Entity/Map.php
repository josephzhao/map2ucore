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

use Map2u\CoreBundle\Entity\BaseMap;

class Map extends BaseMap {

    protected $mapLayers;

    /**
     * Constructor
     */
    public function __construct() {
        parent::__construct();
        $this->mapLayers = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add mapLayers
     *
     * @param \Map2u\CoreBundle\Entity\MapLayer $mapLayers
     * @return mixed
     */
    public function addMapLayer(\Map2u\CoreBundle\Entity\MapLayer $mapLayers) {
        $this->mapLayers[] = $mapLayers;

        return $this;
    }

    /**
     * Remove mapLayers
     *
     * @param \Map2u\CoreBundle\Entity\MapLayer $mapLayers
     */
    public function removeProject(\Map2u\CoreBundle\Entity\MapLayer $mapLayers) {
        $this->mapLayers->removeElement($mapLayers);
    }

}
