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
namespace GI\Component\Captcha\Base\ViewModel\Validator;

use GI\Validator\Container\Recursive\Recursive;
use GI\Component\Captcha\I18n\Glossary;

use GI\Component\Captcha\Base\ViewModel\ViewModelInterface;
use GI\Component\Captcha\I18n\GlossaryInterface;
use GI\Validator\Container\Chain\ChainInterface;
use GI\Security\Captcha\Base\CaptchaInterface as SecureCaptchaInterface;

/**
 * Class Validator
 * @package GI\Component\Captcha\Base\ViewModel\Validator
 *
 * @method ChainInterface getValue()
 */
abstract class AbstractValidator extends Recursive implements ValidatorInterface
{
    /**
     * @var ViewModelInterface
     */
    private $viewModel;


    /**
     * AbstractValidator constructor.
     * @param ViewModelInterface $viewModel
     * @throws \Exception
     */
    public function __construct(ViewModelInterface $viewModel)
    {
        $this->viewModel = $viewModel;

        parent::__construct();

        $param = $this->giTranslate(GlossaryInterface::class, Glossary::class, 'Captcha');
        $this->getValue()->setValidatedParam($param);
    }

    /**
     * @return ViewModelInterface
     */
    protected function getViewModel()
    {
        return $this->viewModel;
    }

    /**
     * @return SecureCaptchaInterface
     */
    abstract protected function getSecureCaptcha();

    /**
     * @return array
     */
    protected function getContents()
    {
        $factory = $this->giGetValidatorFactory();

        $idFinder = function()
        {
            return $this->getViewModel()->getId();
        };

        return [
            'value' => [
                $factory->createNotEmpty()->setBreak(true),
                $factory->createCaptcha($idFinder, $this->getSecureCaptcha())
            ]
        ];
    }
}