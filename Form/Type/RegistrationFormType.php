<?php

/*
 * This file is part of the FOSUserBundle package.
 *
 * (c) FriendsOfSymfony <http://friendsofsymfony.github.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Map2u\CoreBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
#use EWZ\Bundle\RecaptchaBundle\Validator\Constraints\True;
use Symfony\Component\Validator\Constraints\True;

class RegistrationFormType extends AbstractType {

    private $class;

    /**
     * @param string $class The User class name
     */
    public function __construct($class) {
        $this->class = $class;
    }

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('username', null, array('label' => 'form.username', 'translation_domain' => 'FOSUserBundle', 'attr' => array('class' => 'form-control validate[required]')))
                ->add('email', 'email', array('label' => 'form.email', 'translation_domain' => 'FOSUserBundle', 'attr' => array('class' => 'form-control validate[required]')))
                ->add('plainPassword', 'repeated', array(
                    'type' => 'password',
                    'options' => array('translation_domain' => 'FOSUserBundle', 'attr' => array('class' => 'form-control validate[required]')),
                    'first_options' => array('label' => 'form.password'),
                    'second_options' => array('label' => 'form.password_confirmation'),
                    'invalid_message' => 'fos_user.password.mismatch',
                ))
                ->add('recaptcha', 'ewz_recaptcha', array(
                    'label' => 'form.verify_code',
                    'translation_domain' => 'FOSUserBundle',
                    'attr' => array(
                        'options' => array('theme' => 'light', 'type' => 'image'),
                        'class' => 'form-control validate[required]'
                    ),
                    'mapped' => false,
                    'constraints' => array(new True())
                ))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => $this->class,
            'intention' => 'registration',
        ));
    }

    public function getName() {
        return 'map2u_user_registration';
    }

}
