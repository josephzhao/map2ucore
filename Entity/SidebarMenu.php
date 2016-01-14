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

use Map2u\CoreBundle\Entity\BaseCategory;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;

class SidebarMenu extends BaseCategory {

    use ORMBehaviors\Translatable\Translatable;

    protected $id;
    protected $routing;
    protected $expanded;
    protected $clickable;

    /**
     * Set routing
     *
     * @param string $routing
     */
    public function setRouting($routing) {
        $this->routing = $routing;
        return $this;
    }

    /**
     * Get routing
     *
     * @return string $routing
     */
    public function getRouting() {
        return $this->routing;
    }

    /**
     * Set clickable
     *
     * @param string $clickable
     */
    public function setClickable($clickable) {
        $this->clickable = $clickable;
        return $this;
    }

    /**
     * Get clickable
     *
     * @return string $clickable
     */
    public function getClickable() {
        return $this->clickable;
    }

    /**
     * Set expanded
     *
     * @param string $expanded
     */
    public function setExpanded($expanded) {
        $this->expanded = $expanded;
        return $this;
    }

    /**
     * Get expanded
     *
     * @return string $expanded
     */
    public function getExpanded() {
        return $this->expanded;
    }

}
