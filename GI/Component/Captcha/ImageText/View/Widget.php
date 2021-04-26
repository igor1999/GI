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

/**
 * Class Widget
 * @package GI\Component\Captcha\ImageText\View
 *
 * @method ViewModelInterface getViewModel()
 * @method WidgetInterface setViewModel(ViewModelInterface $viewModel)
 * @method string getImageSource()
 * @method WidgetInterface setImageSource(string $imageSource)
 */
class Widget extends AbstractWidget implements WidgetInterface
{
    const CLIENT_JS  = 'gi-captcha-image-text';

    const CLIENT_CSS = self::CLIENT_JS;


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
     * @return ResourceRendererInterface
     */
    protected function getResourceRenderer()
    {
        return $this->resourceRenderer;
    }

    /**
     * @return static
     * @throws \Exception
     */
    protected function build()
    {
        parent::build();

        $this->getContainer()
            ->build(2, 3)
            ->set(0, 0, [$this->captchaImage, $this->getIdHidden()])
            ->set(1, 0, $this->valueText)
            ->set(1, 1, $this->getRecaptchaButton())
            ->set(1, 2, $this->createLoadingImage());

        return $this;
    }

    /**
     * @gi-id captcha-image
     * @return ImageInterface
     * @throws \Exception
     */
    protected function getCaptchaImage()
    {
        if (!($this->captchaImage instanceof ImageInterface)) {
            $src = $this->getImageSource();
            $alt = $this->giTranslate(GlossaryInterface::class, Glossary::class, 'Captcha');

            $this->captchaImage = $this->giGetDOMFactory()->createImage($src, $alt);
        }

        return $this->captchaImage;
    }

    /**
     * @gi-id value-text-image
     * @return TextInterface
     */
    protected function getValueText()
    {
        if (!($this->valueText instanceof TextInterface)) {
            $this->valueText = $this->giGetDOMFactory()->getInputFactory()->createText(
                $this->getViewModel()->getValueName()
            );

            $text = $this->giTranslate(GlossaryInterface::class, Glossary::class,'enter captcha');
            $this->valueText->getAttributes()->setPlaceholder($text);
        }

        return $this->valueText;
    }
}