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
     * @validate
     * @throws \Exception
     */
    protected function validateId()
    {
        if (empty($this->id)) {
            $this->giThrowIsEmptyException('Captcha ID');
        }
    }

    /**
     * @validate
     * @throws \Exception
     */
    protected function validateRecaptchaURI()
    {
        if (empty($this->recaptchaURI)) {
            $this->giThrowIsEmptyException('Recaptcha URI');
        }
    }

    /**
     * @return ViewModelInterface
     */
    abstract protected function getViewModel();

    /**
     * @validate
     * @throws \Exception
     */
    protected function validateViewModel()
    {
        if (!($this->getViewModel() instanceof ViewModelInterface)) {
            $this->giThrowInvalidTypeException('View model', '', 'ViewModelInterface');
        }
    }

    /**
     * @return LayoutInterface
     */
    public function getContainer()
    {
        return $this->container;
    }

    /**
     * @return HiddenInterface
     */
    public function getIdHidden()
    {
        return $this->idHidden;
    }

    /**
     * @return ButtonInterface
     */
    public function getRecaptchaButton()
    {
        return $this->recaptchaButton;
    }

    /**
     * @return ImageInterface
     */
    public function getRecaptchaImage()
    {
        return $this->recaptchaImage;
    }

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
    protected function createContainer()
    {
        $this->container = $this->giGetDOMFactory()->createLayout();

        return $this->container;
    }

    /**
     * @gi-id id-hidden
     * @return HiddenInterface
     */
    protected function createIdHidden()
    {
        $this->idHidden = $this->giGetDOMFactory()->getInputFactory()->createHidden(
            $this->getViewModel()->getIdName(),
            $this->getId()
        );

        return $this->idHidden;
    }

    /**
     * @gi-id recaptcha-button
     * @return ButtonInterface
     * @throws \Exception
     */
    protected function createRecaptchaButton()
    {
        $this->recaptchaButton = $this->giGetDOMFactory()->createButton();

        return $this->recaptchaButton;
    }

    /**
     * @gi-id recaptcha-image
     * @return ImageInterface
     * @throws \Exception
     */
    protected function createRecaptchaImage()
    {
        $this->recaptchaImage = $this->giGetDOMFactory()->createImage(
            $this->getResourceRenderer()->getRecaptchaImage(),
            $this->giTranslate(GlossaryInterface::class, Glossary::class, 'Recaptcha')
        );

        return $this->recaptchaImage;
    }
}