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

class Category extends BaseCategory {

    use ORMBehaviors\Translatable\Translatable;

    protected $id;

}
