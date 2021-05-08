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
namespace GI\Markup\Renderer;

use GI\ServiceLocator\ServiceLocatorAwareTrait;
use GI\Pattern\Validation\ValidationTrait;

use GI\FileSystem\FSO\FSOFile\FSOFileInterface;
use GI\Util\TextProcessing\Escaper\Factory\Container\ContainerInterface as EscaperContainerInterface;
use GI\Util\TextProcessing\MarkupTextProcessor\MarkupTextProcessorInterface;
use GI\REST\URL\Builder\BuilderInterface as URLBuilderInterface;
use GI\DOM\Factory\FactoryInterface as DOMFactoryInterface;
use GI\Storage\Collection\MixedCollection\HashSet\Alterable\AlterableInterface as ParamsInterface;
use GI\DOM\HTML\Element\Input\Hidden\CSRFInterface;

abstract class AbstractRenderer implements RendererInterface
{
    use ServiceLocatorAwareTrait, ValidationTrait;


    const DEFAULT_RELATIVE_PATH = 'template/template.phtml';


    /**
     * @var FSOFileInterface
     */
    private $template;

    /**
     * @var EscaperContainerInterface
     */
    private $escaperContainer;

    /**
     * @var MarkupTextProcessorInterface
     */
    private $markupTextProcessor;

    /**
     * @var URLBuilderInterface
     */
    private $urlBuilder;

    /**
     * @var ParamsInterface
     */
    private $params;


    /**
     * AbstractRenderer constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        $this->setTemplateByClass(static::class);

        $this->escaperContainer = $this->giCreateEscaperContainer();

        $this->markupTextProcessor = $this->giCreateMarkupTextProcessor();

        $this->urlBuilder = $this->giCreateURLBuilder();

        $this->params = $this->giGetStorageFactory()->createMixedHashSetAlterable();
    }

    /**
     * @return FSOFileInterface
     */
    protected function getTemplate()
    {
        return $this->template;
    }

    /**
     * @param FSOFileInterface $template
     * @return static
     */
    protected function setTemplate(FSOFileInterface $template)
    {
        $this->template = $template;

        return $this;
    }

    /**
     * @param string $class
     * @param string $relativePath
     * @return static
     */
    protected function setTemplateByClass(string $class, string $relativePath = '')
    {
        if (empty($relativePath)) {
            $relativePath = static::DEFAULT_RELATIVE_PATH;
        }

        $this->setTemplate($this->giCreateClassDirChildFile($class, $relativePath));

        return $this;
    }

    /**
     * @return EscaperContainerInterface
     */
    public function getEscaperContainer()
    {
        return $this->escaperContainer;
    }

    /**
     * @return MarkupTextProcessorInterface
     */
    public function getMarkupTextProcessor()
    {
        return $this->markupTextProcessor;
    }

    /**
     * @return DOMFactoryInterface
     */
    public function getDOMFactory()
    {
        return $this->giGetDOMFactory();
    }

    /**
     * @return CSRFInterface
     */
    public function createCSRF()
    {
        return $this->getDOMFactory()->getInputFactory()->createCSRF();
    }

    /**
     * @return URLBuilderInterface
     */
    protected function getUrlBuilder()
    {
        return $this->urlBuilder;
    }

    /**
     * @return ParamsInterface
     */
    protected function getParams()
    {
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
     * @return string
     * @throws \Exception
     */
    public function toString()
    {
        $this->validateProperties();

        $this->getTemplate()->fireInexistence();

        if (!$this->getTemplate()->isFile()) {
            $this->giThrowInvalidTypeException('View template', $this->getTemplate()->getPath(), 'file');
        }

        ob_start();
        /** @noinspection PhpIncludeInspection */
        include $this->getTemplate()->toString();

        return ob_get_clean();
    }

    /**
     * @param FSOFileInterface $target
     * @return static
     * @throws \Exception
     */
    public function save(FSOFileInterface $target)
    {
        $target->getWriteStream()->writeAndClose($this->toString());

        return $this;
    }
}