<?php

namespace Map2u\CoreBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Security\Core\SecurityContext;
use Sonata\DoctrineMongoDBAdminBundle\Model\ModelManager;
use Doctrine\Common\Persistence\ObjectManager;

class UserSecurityType extends AbstractType {

    private $conn;

    /**
     * @param ObjectManager $conn
     */
    public function __construct($conn) {
        $this->conn = $conn;

        //var_dump($this->conn);
    }

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $countries = null;
        $countries_array = array();

        if (isset($this->conn) && $this->conn != null) {
            $sql = "select * from tab_country";
            $countries = $this->conn->fetchAll($sql);
            foreach ($countries as $country) {
                $countries_array[$country['country_code']] = $country['country_name'];
            }
        }
        $builder
                ->add('id', 'hidden')
                ->add('currentPassword', "password", array("mapped" => false,'required'=>true))
                ->add('plainPassword', "password", array("mapped" => false,'required'=>true))
                ->add('confirmationPassword', "password", array("mapped" => false,'required'=>true))

        ;
    }

    public function getName() {
        // no_label is a custom widget that renders field_row without the label

        return 'usersecuritytype';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Application\Sonata\UserBundle\Entity\User',
        ));
    }

    public function getDefaultOptions(array $options) {
        return array('data_class' => 'Application\Sonata\UserBundle\Entity\User');
    }

}
