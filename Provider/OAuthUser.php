<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Map2u\CoreBundle\Provider;

use HWI\Bundle\OAuthBundle\Security\Core\User\OAuthUser as HWIOAuthUser;

class OAuthUser extends HWIOAuthUser{
  
    private $isAdmin = false;
    public function __construct($username, $isAdmin = false)
    {
        parent::__construct($username);
        $this->isAdmin = $isAdmin;
    }

    public function getRoles()
    {
        $roles = array('ROLE_USER', 'ROLE_OAUTH_USER');

        if ($this->isAdmin) {
            array_push($roles, 'ROLE_SUPER_ADMIN');
        }

        return $roles;
    }
    public function __toString() {
      return $this->username;
    }
}