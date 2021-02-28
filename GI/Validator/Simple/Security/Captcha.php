<?php
/*
 * This file is part of PHP-framework GI.
 *
 * PHP-framework GI is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * PHP-framework GI is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with PHP-framework GI. If not, see <https://www.gnu.org/licenses/>.
 */
namespace GI\Validator\Simple\Security;

use GI\Validator\Simple\Base\AbstractSimple;
use GI\Validator\I18n\DefaultMessages;
use GI\Validator\I18n\Glossary\Glossary;

use GI\Security\Captcha\Base\CaptchaInterface as SecureCaptchaInterface;
use GI\Validator\I18n\Glossary\GlossaryInterface;

class Captcha extends AbstractSimple implements CaptchaInterface
{
    /**
     * @var \Closure
     */
    private $idFinder;

    /**
     * @var SecureCaptchaInterface
     */
    private $secureCaptcha;


    /**
     * Captcha constructor.
     * @param \Closure $idFinder
     * @param SecureCaptchaInterface $secureCaptcha
     * @param string $validatedParam
     */
    public function __construct(\Closure $idFinder, SecureCaptchaInterface $secureCaptcha, string $validatedParam = '')
    {
        parent::__construct($validatedParam);

        $this->idFinder      = $idFinder;
        $this->secureCaptcha = $secureCaptcha;
    }

    /**
     * @return \Closure
     */
    public function getIdFinder()
    {
        return $this->idFinder;
    }

    /**
     * @param \Closure $idFinder
     * @return static
     */
    protected function setIdFinder(\Closure $idFinder)
    {
        $this->idFinder = $idFinder;

        return $this;
    }

    /**
     * @return SecureCaptchaInterface
     */
    public function getSecureCaptcha()
    {
        return $this->secureCaptcha;
    }

    /**
     * @param SecureCaptchaInterface $secureCaptcha
     * @return static
     */
    protected function setSecureCaptcha(SecureCaptchaInterface $secureCaptcha)
    {
        $this->secureCaptcha = $secureCaptcha;

        return $this;
    }

    /**
     * @return bool
     */
    protected function doValidation()
    {
        $id = call_user_func($this->getIdFinder());

        return $this->getSecureCaptcha()->validate($id, $this->getSource());
    }

    /**
     * @return string
     */
    protected function getMessage()
    {
        return $this->giTranslate(
            GlossaryInterface::class, Glossary::class,DefaultMessages::CAPTCHA
        );
    }
}