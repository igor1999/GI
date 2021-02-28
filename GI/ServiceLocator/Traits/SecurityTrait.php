<?php

namespace GI\ServiceLocator\Traits;

use GI\Security\CSRF\CSRF;
use GI\Security\Captcha\Factory\Factory as CaptchaFactory;

use GI\ServiceLocator\ServiceLocatorInterface;
use GI\Security\Captcha\Factory\FactoryInterface as CaptchaFactoryInterface;
use GI\Security\CSRF\CSRFInterface;

trait SecurityTrait
{
    /**
     * @var CaptchaFactoryInterface
     */
    private $captchaFactory;


    /**
     * @param string|null $caller
     * @return CaptchaFactoryInterface
     */
    public function getCaptchaFactory(string $caller = null)
    {
        /** @var ServiceLocatorInterface $me */
        $me = $this;

        try {
            $result = $me->getDi()->find(CaptchaFactoryInterface::class, $caller);
        } catch (\Exception $e) {
            if (!($this->captchaFactory instanceof CaptchaFactoryInterface)) {
                $this->captchaFactory = new CaptchaFactory();
            }

            $result = $this->captchaFactory;
        }

        return $result;
    }

    /**
     * @param string|null $caller
     * @return CSRFInterface
     */
    public function createSecureCSRF(string $caller = null)
    {
        /** @var ServiceLocatorInterface $me */
        $me = $this;

        try {
            $result = $me->getDi()->find(CSRFInterface::class, $caller);
        } catch (\Exception $e) {
            $result = new CSRF();
        }

        return $result;
    }
}