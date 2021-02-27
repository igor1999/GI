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
namespace GI\Component\Captcha\ImageText;

use GI\Component\Base\AbstractComponent;
use GI\Component\Captcha\ImageText\View\Widget;
use GI\Component\Captcha\ImageText\ViewModel\ViewModel;
use GI\Security\Captcha\ImageText\ImageText as SecureCaptcha;

use GI\Component\Captcha\ImageText\View\WidgetInterface;
use GI\Component\Captcha\ImageText\ViewModel\ViewModelInterface;
use GI\Security\Captcha\ImageText\ImageTextInterface as SecureCaptchaInterface;
use GI\Component\Captcha\ImageText\Context\ContextInterface;

class ImageText extends AbstractComponent implements ImageTextInterface
{
    /**
     * @var WidgetInterface
     */
    private $view;

    /**
     * @var ViewModelInterface
     */
    private $viewModel;

    /**
     * @var SecureCaptchaInterface
     */
    private $secureCaptcha;

    /**
     * @var string
     */
    private $recaptchaURI = '';


    /**
     * ImageText constructor.
     * @param ViewModelInterface|null $viewModel
     * @throws \Exception
     */
    public function __construct(ViewModelInterface $viewModel = null)
    {
        $this->view = $this->giGetDi(WidgetInterface::class, Widget::class);

        if ($viewModel instanceof ViewModelInterface) {
            $this->viewModel = $viewModel;
        } else {
            $this->viewModel = $this->giGetDi(ViewModelInterface::class, ViewModel::class);
        }

        $this->secureCaptcha = $this->giGetDi(SecureCaptchaInterface::class, SecureCaptcha::class);

        $this->createRecaptchaURI();
    }

    /**
     * @return WidgetInterface
     */
    public function getView()
    {
        return $this->view;
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
    protected function getSecureCaptcha()
    {
        return $this->secureCaptcha;
    }

    /**
     * @return string
     */
    protected function getRecaptchaURI()
    {
        return $this->recaptchaURI;
    }

    /**
     * @return static
     * @throws \Exception
     */
    protected function createRecaptchaURI()
    {
        try {
            /** @var ContextInterface $context */
            $context = $this->giGetDi(ContextInterface::class);

            $this->recaptchaURI = $context->getRecaptchaURI();
        } catch (\Exception $e) {
            $this->giThrowDependencyException('ContextInterface');
        }

        return $this;
    }

    /**
     * @return string
     * @throws \Exception
     */
    public function toString()
    {
        $generator = $this->getSecureCaptcha();
        $generator->generate();

        return $this->getView()
            ->setViewModel($this->getViewModel())
            ->setImageSource($generator->getGraphic()->getBase64EncodedImage())
            ->setId($generator->getId())
            ->setRecaptchaURI($this->recaptchaURI)
            ->toString();
    }

    /**
     * @return array
     * @throws \Exception
     */
    public function getRecaptchaContents()
    {
        $generator = $this->getSecureCaptcha();
        $generator->generate();

        return [
            'id'  => $generator->getId(),
            'src' => $generator->getGraphic()->getBase64EncodedImage(),
        ];
    }
}