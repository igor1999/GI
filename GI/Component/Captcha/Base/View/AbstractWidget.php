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
namespace GI\Component\Captcha\Base\View;

use GI\Component\Base\View\Widget\AbstractWidget as Base;
use GI\Component\Captcha\I18n\Glossary;

use GI\Component\Captcha\Base\ViewModel\ViewModelInterface;
use GI\DOM\HTML\Element\Button\ButtonInterface;
use GI\DOM\HTML\Element\Div\FloatingLayout\LayoutInterface;
use GI\DOM\HTML\Element\Image\ImageInterface;
use GI\DOM\HTML\Element\Input\Hidden\HiddenInterface;
use GI\Component\Captcha\I18n\GlossaryInterface;

/**
 * Class AbstractWidget
 * @package GI\Component\Captcha\Base\View
 *
 * @method ViewModelInterface getViewModel()
 * @method WidgetInterface setViewModel(ViewModelInterface $viewModel)
 * @method string getId()
 * @method WidgetInterface setId(string $id)
 * @method string getRecaptchaURI()
 * @method WidgetInterface setRecaptchaURI(string $recaptchaURI)
 */
abstract class AbstractWidget extends Base implements WidgetInterface
{
    const CLIENT_CSS              = 'gi-captcha-base';

    const ATTRIBUTE_RECAPTCHA_URL = 'recaptcha-url';


    /**
     * @var LayoutInterface
     */
    private $container;

    /**
     * @var HiddenInterface
     */
    private $idHidden;

    /**
     * @var ButtonInterface
     */
    private $recaptchaButton;

    /**
     * @var ImageInterface
     */
    private $recaptchaImage;


    /**
     * @return ResourceRendererInterface
     */
    abstract protected function getResourceRenderer();

    /**
     * @return static
     * @throws \Exception
     */
    protected function build()
    {
        $this->getServerDataList()->set(static::ATTRIBUTE_RECAPTCHA_URL, $this->getRecaptchaURI());

        $this->recaptchaButton->getChildNodes()->set($this->recaptchaImage);

        return $this;
    }

    /**
     * @render
     * @gi-id container
     * @return LayoutInterface
     */
    protected function getContainer()
    {
        if (!($this->container instanceof LayoutInterface)) {
            $this->container = $this->getGiServiceLocator()->getDOMFactory()->createLayout();
        }

        return $this->container;
    }

    /**
     * @gi-id id-hidden
     * @return HiddenInterface
     */
    protected function getIdHidden()
    {
        if (!($this->idHidden instanceof HiddenInterface)) {
            $this->idHidden = $this->getGiServiceLocator()->getDOMFactory()->getInputFactory()->createHidden(
                $this->getViewModel()->getIdName(),
                $this->getId()
            );
        }

        return $this->idHidden;
    }

    /**
     * @gi-id recaptcha-button
     * @return ButtonInterface
     * @throws \Exception
     */
    protected function getRecaptchaButton()
    {
        if (!($this->recaptchaButton instanceof ButtonInterface)) {
            $this->recaptchaButton = $this->getGiServiceLocator()->getDOMFactory()->createButton();
        }

        return $this->recaptchaButton;
    }

    /**
     * @gi-id recaptcha-image
     * @return ImageInterface
     * @throws \Exception
     */
    protected function getRecaptchaImage()
    {
        if (!($this->recaptchaImage instanceof ImageInterface)) {
            $src = $this->getResourceRenderer()->getRecaptchaImage();
            $alt = $this->getGiServiceLocator()->translate(GlossaryInterface::class, Glossary::class, 'Recaptcha');

            $this->recaptchaImage = $this->getGiServiceLocator()->getDOMFactory()->createImage($src, $alt);
        }

        return $this->recaptchaImage;
    }
}