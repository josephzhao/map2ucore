<?php

namespace Map2u\CoreBundle\Listener;

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Http\Authentication\DefaultAuthenticationSuccessHandler;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Http\HttpUtils;

class AuthenticationSuccessHandler extends DefaultAuthenticationSuccessHandler {

    protected $router;

    public function __construct(HttpUtils $httpUtils, array $options, $router) {
        $this->router = $router;
        parent::__construct($httpUtils, $options);
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token) {
        if (true === $request->isXmlHttpRequest()) {
            return new JsonResponse(array('success' => true, 'token'=>$token, 'status' => 'ok'));
        }

        //default redirect operation.
//        if ($this->security->isGranted('ROLE_SUPER_ADMIN')) {
//            $response = new RedirectResponse($this->router->generate('dashboard_index'));
//        } elseif ($this->security->isGranted('ROLE_ADMIN')) {
//            $response = new RedirectResponse($this->router->generate('category_index'));
//        } elseif ($this->security->isGranted('ROLE_USER')) {
//            $response = new RedirectResponse($this->router->generate('welcome_home'));
//        }
        $response = new RedirectResponse($this->router->generate('welcome_home'));
        return $response;

        // return parent::onAuthenticationSuccess($request, $token);
    }

}

?>
