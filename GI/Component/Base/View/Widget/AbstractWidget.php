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
namespace GI\Component\Base\View\Widget;

use GI\Component\Base\View\LoadingImage\LoadingImage;

use GI\Component\Base\View\ServerData\ServerDataAwareTrait;
use GI\ServiceLocator\ServiceLocatorAwareTrait;
use GI\Component\Base\View\ClientAttributes\ClientAttributesTrait;
use GI\Pattern\Validation\ValidationTrait;
use GI\Component\Base\View\Relations\RelationsAwareTrait;

use GI\DOM\HTML\Element\HTMLInterface;
use GI\Component\Base\View\Siblings\SiblingsInterface;
use GI\DOM\HTML\Element\ContainerElementInterface;
use GI\Component\Base\View\ResourceRenderer\ResourceRendererInterface;
use GI\DOM\HTML\Element\Input\Hidden\CSRFInterface;
use GI\Component\Base\View\LoadingImage\LoadingImageInterface;
use GI\Storage\Collection\MixedCollection\HashSet\Alterable\AlterableInterface as ParamsInterface;

abstract class AbstractWidget implements WidgetInterface
{
    use ServiceLocatorAwareTrait, ClientAttributesTrait, ValidationTrait, RelationsAwareTrait, ServerDataAwareTrait;


    const CLIENT_JS  = '';

    const CLIENT_CSS = '';


    /**
     * @var ContainerElementInterface
     */
    private $renderingContainer;

    /**
     * @var CSRFInterface
     */
    private $csrf;

    /**
     * @var ParamsInterface
     */
    private $params;


    /**
     * @return string
     */
    public function getClientJSClass()
    {
        return static::CLIENT_JS;
    }

    /**
     * @return ContainerElementInterface
     */
    protected function getRenderingContainer()
    {
        if (!($this->renderingContainer instanceof ContainerElementInterface)) {
            $this->renderingContainer = $this->getGiServiceLocator()->getDOMFactory()->createContainerElement();
        }

        return $this->renderingContainer;
    }

    /**
     * @return ResourceRendererInterface
     * @throws \Exception
     */
    abstract protected function getResourceRenderer();

    /**
     * @return CSRFInterface
     * @throws \Exception
     */
    protected function getCsrf()
    {
        if (!($this->csrf instanceof CSRFInterface)) {
            $this->getGiServiceLocator()->throwNotSetException('CSRF');
        }

        return $this->csrf;
    }

    /**
     * @return static
     */
    protected function createCsrf()
    {
        $this->csrf = $this->getGiServiceLocator()->getDOMFactory()->getInputFactory()->createCSRF();

        return $this;
    }

    /**
     * @param string $giId
     * @return LoadingImageInterface
     * @throws \Exception
     */
    protected function createLoadingImage(string $giId = '')
    {
        try {
            $image = $this->getGiServiceLocator()->getDependency(LoadingImageInterface::class);
        } catch (\Exception $exception) {
            $image = new LoadingImage();
        }

        $this->addClientAttributes($image, $giId);

        return $image;
    }

    /**
     * @return ParamsInterface
     */
    protected function getParams()
    {
        if (!($this->params instanceof ParamsInterface)) {
            $this->params = $this->getGiServiceLocator()->getStorageFactory()->createMixedHashSetAlterable();
        }

        return $this->params;
    }

    /**
     * @param string $method
     * @param array $arguments
     * @return static|mixed
     * @throws \Exception
     */
    public function __call(string $method, array $arguments = [])
    {
        $result = call_user_func_array([$this->getParams(), $method], $arguments);

        if ($result === $this->getParams()) {
            $result = $this;
        }

        return $result;
    }

    /**
     * @return static
     * @throws \Exception
     */
    protected function create()
    {
        $this->validateProperties()->createWithAttributes()->createSimple();

        return $this;
    }

    /**
     * @return static
     * @throws \Exception
     */
    protected function createWithAttributes()
    {
        $methods = $this->getGiServiceLocator()->getClassMeta()->getMethods()->findByDescriptorName(static::ATTRIBUTE_GI_ID);

        $withJSClass = true;

        foreach ($methods as $method) {
            $giID       = (string)$method->getDescriptor(static::ATTRIBUTE_GI_ID);
            $isRendered = $method->hasDescriptor(static::RENDERING_DESCRIPTOR);
            $element    = $method->execute($this);

            if ($element instanceof HTMLInterface) {
                if ($isRendered) {
                    $this->getRenderingContainer()->getChildNodes()->add($element);
                }

                $this->addClientAttributes($element, $giID, $withJSClass);

                $withJSClass = false;
            } elseif ($element instanceof SiblingsInterface) {
                $this->addClientAttributesToSiblings($element);
            } else {
                $type = HTMLInterface::class . '|' . SiblingsInterface::class;
                $this->getGiServiceLocator()->throwInvalidTypeException('Result of method', $method->getName(), $type);
            }
        }

        return $this;
    }

    /**
     * @return static
     * @throws \Exception
     */
    protected function createSimple()
    {
        $methods = $this->getGiServiceLocator()->getClassMeta()->getMethods()->findByDescriptorName(static::CREATING_DESCRIPTOR);

        foreach ($methods as $method) {
            $method->execute($this);
        }

        return $this;
    }

    /**
     * @return static
     */
    abstract protected function build();

    /**
     * @return string
     * @throws \Exception
     */
    public function toString()
    {
        $this->create()->build();

        $result = $this->getRelationList()->toString();

        $result .= $this->getServerDataList()->toString();

        try {
            $result .= $this->getCsrf()->toString();
        } catch (\Exception $e) {}

        try {
            $result .= $this->getResourceRenderer()->toString();
        } catch (\Exception $e) {}

        $result .= $this->getRenderingContainer()->toString();

        return $result;
    }
}