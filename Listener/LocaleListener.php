<?php

namespace Map2u\CoreBundle\Listener;

use Symfony\Component\HttpKernel\Event\GetResponseEvent;

class LocaleListener {

    protected $locale;

    public function onKernelRequest(GetResponseEvent $event) {
        $this->locale = $event->getRequest()->getLocale();
    }

    public function getLocale() {
        return $this->locale;
    }

}
?>