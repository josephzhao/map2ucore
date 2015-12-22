<?php

namespace Map2u\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;

/**
 * UserDrawLayerTranslation
 */
class UserDrawLayerTranslation {

   // use ORMBehaviors\Translatable\Translation;

    /**
     * @var string
     */
    private $name;
    protected $id;

    /**
     * @var string
     */
    private $description;
  
    /**
     * Set name
     *
     * @param string $name
     * @return UserDrawLayerTranslation
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
     * Set description
     *
     * @param string $description
     * @return UserDrawLayerTranslation
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

}
