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
namespace GI\Component\Captcha\ImageText\View;

use GI\Component\Captcha\Base\View\AbstractWidget;
use GI\Component\Captcha\I18n\Glossary;

use GI\Component\Captcha\ImageText\ViewModel\ViewModelInterface;
use GI\DOM\HTML\Element\Image\ImageInterface;
use GI\DOM\HTML\Element\Input\Text\TextInterface;
use GI\Component\Captcha\I18n\GlossaryInterface;

class Widget extends AbstractWidget implements WidgetInterface
{
    const CLIENT_JS  = 'gi-captcha-image-text';

    const CLIENT_CSS = self::CLIENT_JS;


    /**
     * @var ViewModelInterface
     */
    private $viewModel;

    /**
     * @var string
     */
    private $imageSource = '';

    /**
     * @var ResourceRendererInterface
     */
    private $resourceRenderer;

    /**
     * @var ImageInterface
     */
    private $captchaImage;

    /**
     * @var TextInterface
     */
    private $valueText;


    /**
     * Widget constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        $this->resourceRenderer = $this->giGetDi(
            ResourceRendererInterface::class, ResourceRenderer::class
        );
    }

    /**
     * @return ViewModelInterface
     */
    protected function getViewModel()
    {
        return $this->viewModel;
    }

    /**
     * @param ViewModelInterface $viewModel
     * @return static
     */
    public function setViewModel(ViewModelInterface $viewModel)
    {
        $this->viewModel = $viewModel;

        return $this;
    }

    /**
     * @return string
     */
    protected function getImageSource()
    {
        return $this->imageSource;
    }

    /**
     * @param string $imageSource
     * @return static
     */
    public function setImageSource(string $imageSource)
    {
        $this->imageSource = $imageSource;

        return $this;
    }

    /**
     * @return ResourceRendererInterface
     */
    protected function getResourceRenderer()
    {
        return $this->resourceRenderer;
    }

    /**
     * @return ImageInterface
     */
    public function getCaptchaImage()
    {
        return $this->captchaImage;
    }

    /**
     * @return TextInterface
     */
    public function getValueText()
    {
        return $this->valueText;
    }

    /**
     * @return static
     * @throws \Exception
     */
    protected function build()
    {
        parent::build();

        $this->getContainer()
            ->build(2, 2)
            ->set(0, 0, [$this->captchaImage, $this->getIdHidden()])
            ->set(1, 0, $this->valueText)
            ->set(1, 1, $this->getRecaptchaButton());

        return $this;
    }

    /**
     * @gi-id captcha-image
     * @return ImageInterface
     * @throws \Exception
     */
    protected function createCaptchaImage()
    {
        $this->captchaImage = $this->giGetDOMFactory()->createImage(
            $this->imageSource,
            $this->giTranslate(GlossaryInterface::class, Glossary::class,'Captcha')
        );

        return $this->captchaImage;
    }

    /**
     * @gi-id value-text-image
     * @return TextInterface
     */
    protected function createValueText()
    {
        $this->valueText = $this->giGetDOMFactory()->getInputFactory()->createText(
            $this->getViewModel()->getValueName()
        );

        $this->valueText->getAttributes()->setPlaceholder(
            $this->giTranslate(GlossaryInterface::class, Glossary::class,'enter captcha')
        );

        return $this->valueText;
    }
}