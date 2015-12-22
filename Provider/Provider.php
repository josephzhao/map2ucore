<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Map2u\CoreBundle\Provider;

use HWI\Bundle\OAuthBundle\Security\Core\User\OAuthUserProvider;
use HWI\Bundle\OAuthBundle\OAuth\Response\UserResponseInterface;
use Application\Sonata\UserBundle\Entity\User;
use Map2u\CoreBundle\Provider\OAuthUser;

class Provider extends OAuthUserProvider {

  protected $session, $doctrine, $admins;

  public function __construct($session, $doctrine, $admins) {
    $this->session = $session;
    $this->doctrine = $doctrine;
    $this->admins = $admins;
  }

  public function loadUserByUsername($username) {
    return new OAuthUser($username, $this->isUserAdmin($username)); //look at the class below
  }

  private function isUserAdmin($nickname) {
    return in_array($nickname, $this->admins);
  }

  public function loadUserByOAuthUserResponse(UserResponseInterface $response) {

    $nameArray = $this->setResArrary($response);
    $this->setSessions($nameArray);
    $result = $this->getQueryResult($nameArray);
    //add to database if doesn't exists
    if (!count($result)) {
      if (isset($nameArray['email']) && !empty($nameArray['email'])) {
        $id = $this->onCreateNewUser($nameArray);
      }
      else {
        return;
      }
    }
    else {
      $id = $result[0]['id'];
    }
    //set id
    $this->session->set('id', $id);

    //@TODO: hmm : is admin
    if ($this->isUserAdmin($nameArray['nickname'])) {
      $this->session->set('is_admin', true);
    }
    //parent:: returned value
    return $this->loadUserByUsername($response->getNickname());
  }

  public function supportsClass($class) {
    return $class === 'Map2u\\CoreBundle\\Provider\\OAuthUser';
  }

  /*
   * set array with response parameters
   * parameter object $response
   * return array
   */

  private function setResArrary($response) {
    $nameArray = array();
    $nameArray['service'] = $response->getResourceOwner()->getName();
    $nameArray['facebook_id'] = $response->getUsername();
    $nameArray['nickname'] = $response->getNickname();
    $nameArray['realname'] = $response->getRealName();
    $nameArray['email'] = $response->getEmail();
    $nameArray['avatar'] = $response->getProfilePicture();
    return $nameArray;
  }

  /*
   * set session with parameters
   * parameter array
   * no return 
   */

  private function setSessions($nameArray) {
    //set data in session
    $this->session->set('nickname', $nameArray['nickname']);
    $this->session->set('realname', $nameArray['realname']);
    $this->session->set('email', $nameArray['email']);
    $this->session->set('avatar', $nameArray['avatar']);
  }

  /*
   * create new user and set user parameters
   * parameter array $nameArray
   * return user entity
   */

  private function onCreateNewUser($nameArray) {
    $user = new User();
    $user->setCreatedAt(new \DateTime());
    $user->setUsername($nameArray['nickname']);
    $user->setFacebookName($nameArray['realname']);
    $user->setEmail($nameArray['email']);
    $user->setPlainPassword($nameArray['email']);
    $user->setFacebookData($nameArray['avatar']);
    $user->setFacebookUid($nameArray['facebook_id']);
    $em = $this->doctrine->getManager();
    $em->persist($user);
    return $em->flush();
  }

  private function getQueryResult($nameArray) {
    //get user by fid
    $qb = $this->doctrine->getManager()->createQueryBuilder();
    $qb->select('u.id')
        ->from('ApplicationSonataUserBundle:User', 'u')
        ->where("u.facebookUid = :facebook_uid or u.email = :email")
        ->setParameter('facebook_uid', $nameArray['facebook_id'])
        ->setParameter('email', $nameArray['email'])
        ->setMaxResults(1);
    return $qb->getQuery()->getResult();
  }

}
