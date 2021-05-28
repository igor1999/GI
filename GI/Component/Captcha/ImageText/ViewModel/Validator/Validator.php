<?php

namespace GI\Component\Captcha\ImageText\ViewModel\Validator;

use GI\Component\Captcha\Base\ViewModel\Validator\AbstractValidator;

use GI\Security\Captcha\ImageText\ImageTextInterface as ImageTextCaptchaInterface;

class Validator extends AbstractValidator implements ValidatorInterface
{
    /**
     * @return ImageTextCaptchaInterface
     */
    protected function getSecureCaptcha()
    {
        return $this->getGiServiceLocator()->getCaptchaFactory()->createImageText();
    }
}