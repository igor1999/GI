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
namespace GI\Component\Base\View\ResourceRenderer;

use GI\Component\Base\View\ResourceRenderer\Resource\JS\JS;
use GI\Component\Base\View\ResourceRenderer\Resource\CSS\CSS;
use GI\Storage\Collection\StringCollection\HashSet\Alterable\Alterable as Images;
use GI\Component\Base\View\ResourceRenderer\ClassContents\ClassContents;

use GI\ServiceLocator\ServiceLocatorAwareTrait;

use GI\Component\Base\View\ResourceRenderer\Resource\ResourceInterface;
use GI\Component\Base\View\ResourceRenderer\Resource\JS\JSInterface;
use GI\Component\Base\View\ResourceRenderer\Resource\CSS\CSSInterface;
use GI\FileSystem\FSO\FSODir\FSODirInterface;
use GI\FileSystem\FSO\FSOFile\FSOFileInterface;
use GI\Storage\Collection\StringCollection\HashSet\Alterable\AlterableInterface as ImagesInterface;
use GI\Component\Base\View\ResourceRenderer\ClassContents\ClassContentsInterface;

abstract class AbstractResourceRenderer implements ResourceRendererInterface
{
    use ServiceLocatorAwareTrait;


    const TARGET_RELATIVE_DIR = '';

    const DEFAULT_TARGET_RELATIVE_DIR = 'web';

    const URL_BASE_DIR = '';

    const CSS_PATHS   = [];

    const JS_PATHS    = [];

    const IMAGE_PATHS = [];


    /**
     * @var array
     */
    private static $classContentsCache = [];

    /**
     * @var ResourceInterface[]
     */
    private $items = [];

    /**
     * @var ImagesInterface
     */
    private $images;


    /**
     * @param string $class
     * @param string|null $urlClass
     * @return static
     * @throws \Exception
     */
    protected function createClassContents(string $class, string $urlClass = null)
    {
        if (!isset(self::$classContentsCache[$class])) {
            self::$classContentsCache[$class] = $this->createClassContentsContainer($class);
        }

        if (!empty($urlClass) && !isset(self::$classContentsCache[$urlClass])) {
            self::$classContentsCache[$urlClass] = $this->createClassContentsContainer($urlClass);
        }

        $classContents = self::$classContentsCache[$class];

        if (!empty($urlClass)) {
            $urlBaseDir = self::$classContentsCache[$urlClass]->validate()->getUrlBaseDir();
        } else {
            $urlBaseDir = $classContents->validate()->getUrlBaseDir();
        }

        $this->createContents(
            $classContents->getTargetClass(),
            $classContents->getTargetRelativeDir(),
            $urlBaseDir,
            $classContents->getCssPaths(),
            $classContents->getJsPaths(),
            $classContents->getImagePaths()
        );

        return $this;
    }

    /**
     * @param string $class
     * @return ClassContentsInterface
     * @throws \Exception
     */
    protected function createClassContentsContainer(string $class)
    {
        try {
            $result = $this->getGiServiceLocator()->getDependency(ClassContentsInterface::class, ClassContents::class, [$class]);
        } catch (\Exception $exception) {
            $result = new ClassContents($class);
        }

        return $result;
    }

    /**
     * @return ImagesInterface
     * @throws \Exception
     */
    protected function getImages()
    {
        if (!($this->images instanceof ImagesInterface)) {
            $option = $this->getGiServiceLocator()->getStorageFactory()->getOptionFactory()->createStringHashSet();
            $option->setKeyFormatToHyphenLowerCase();
            $this->images = $this->getGiServiceLocator()->getDependency(ImagesInterface::class, Images::class, [[], $option]);
        }

        return $this->images;
    }

    /**
     * @param string $relativeURL
     * @return bool
     */
    public function has(string $relativeURL)
    {
        return array_key_exists($relativeURL, $this->items);
    }

    /**
     * @param string $relativeURL
     * @return ResourceInterface
     * @throws \Exception
     */
    public function get(string $relativeURL)
    {
        if (!$this->has($relativeURL)) {
            $this->getGiServiceLocator()->throwNotInScopeException($relativeURL);
        }

        return $this->items[$relativeURL];
    }

    /**
     * @return ResourceInterface[]
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * @return int
     */
    public function getLength()
    {
        return count($this->items);
    }

    /**
     * @return int
     */
    public function isEmpty()
    {
        return empty($this->items);
    }

    /**
     * @param string $relativeURL
     * @param ResourceInterface $item
     * @return static
     */
    protected function addResource(string $relativeURL, ResourceInterface $item)
    {
        $this->items[$relativeURL] = $item;

        return $this;
    }

    /**
     * @param FSOFileInterface $target
     * @param string $relativeURL
     * @return static
     */
    protected function addJS(FSOFileInterface $target, string $relativeURL)
    {
        $item = $this->createJSResource($target, $relativeURL);

        $this->addResource($relativeURL, $item);

        return $this;
    }

    /**
     * @param FSODirInterface $targetBase
     * @param FSODirInterface $urlBase
     * @param string $relativePath
     * @return static
     */
    protected function addJSByRelativePath(FSODirInterface $targetBase, FSODirInterface $urlBase, string $relativePath)
    {
        $target = $targetBase->createChildFile($relativePath);
        $url    = $urlBase->createChildFile($relativePath)->getPath();

        $this->addJS($target, $url);

        return $this;
    }

    /**
     * @param FSOFileInterface $target
     * @param string $relativeURL
     * @return static
     */
    protected function addCSS(FSOFileInterface $target, string $relativeURL)
    {
        $item = $this->createCSSResource($target, $relativeURL);

        $this->addResource($relativeURL, $item);

        return $this;
    }

    /**
     * @param FSODirInterface $targetBase
     * @param FSODirInterface $urlBase
     * @param string $relativePath
     * @return static
     */
    protected function addCSSByRelativePath(FSODirInterface $targetBase, FSODirInterface $urlBase, string $relativePath)
    {
        $target = $targetBase->createChildFile($relativePath);
        $url    = $urlBase->createChildFile($relativePath)->getPath();

        $this->addCSS($target, $url);

        return $this;
    }

    /**
     * @param FSOFileInterface $target
     * @param string $relativeURL
     * @return JSInterface
     */
    protected function createJSResource(FSOFileInterface $target, string $relativeURL)
    {
        try {
            $resource = $this->getGiServiceLocator()->getDependency(
                JSInterface::class, JS::class, [$target, $relativeURL]
            );
        } catch (\Exception $exception) {
            $resource = new JS($target, $relativeURL);
        }

        return $resource;
    }

    /**
     * @param FSOFileInterface $target
     * @param string $relativeURL
     * @return CSSInterface
     */
    protected function createCSSResource(FSOFileInterface $target, string $relativeURL)
    {
        try {
            $resource = $this->getGiServiceLocator()->getDependency(
                CSSInterface::class, CSS::class, [$target, $relativeURL]
            );
        } catch (\Exception $exception) {
            $resource = new CSS($target, $relativeURL);
        }

        return $resource;
    }

    /**
     * @param string $targetClass
     * @param string $targetRelativeDir
     * @param string $urlDir
     * @param array $css
     * @param array $js
     * @param array $images
     * @return static
     * @throws \Exception
     */
    protected function createContents(
        string $targetClass, string $targetRelativeDir, string $urlDir,
        array $css = [], array $js = [], array $images = [])
    {
        if (empty($targetRelativeDir)) {
            $targetRelativeDir = static::DEFAULT_TARGET_RELATIVE_DIR;
        }

        $targetBase = $this->getGiServiceLocator()->createClassDirChildDir($targetClass, $targetRelativeDir);
        $urlBase    = $this->getGiServiceLocator()->createFSODir($urlDir);

        foreach ($css as $path) {
            $this->addCSSByRelativePath($targetBase, $urlBase, $path);
        }

        foreach ($js as $path) {
            $this->addJSByRelativePath($targetBase, $urlBase, $path);
        }

        foreach ($images as $key => $path) {
            $urlHolder = $this->getGiServiceLocator()->createURLHolderByRelativePath($targetBase, $urlBase, $path);
            if (is_string($key)) {
                $this->getImages()->set($key, $urlHolder->getUrlWithModificationTime());
            }
        }

        return $this;
    }

    /**
     * @param string $method
     * @param array $arguments
     * @return string
     * @throws \Exception
     */
    public function __call(string $method, array $arguments = [])
    {
        return call_user_func([$this->getImages(), $method]);
    }

    /**
     * @param string $relativeURL
     * @return bool
     */
    protected function remove(string $relativeURL)
    {
        if ($result = $this->has($relativeURL)) {
            unset($this->items[$relativeURL]);
        }

        return $result;
    }

    /**
     * @return static
     */
    protected function clean()
    {
        $this->items = [];

        return $this;
    }

    /**
     * @return string
     * @throws \Exception
     */
    public function toString()
    {
        $f = function($item)
        {
            return ($item instanceof ResourceInterface);
        };
        $items = array_filter($this->getItems(), $f);

        $f = function(ResourceInterface $item)
        {
            return $item->toString();
        };
        $items = array_map($f, $items);

        return implode(PHP_EOL, $items);
    }
}