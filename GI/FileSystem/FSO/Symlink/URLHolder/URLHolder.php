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
namespace GI\FileSystem\FSO\Symlink\URLHolder;

use GI\FileSystem\FSO\Symlink\URLHolder\Context\Context;

use GI\ServiceLocator\ServiceLocatorAwareTrait;

use GI\FileSystem\FSO\FSODir\FSODirInterface;
use GI\FileSystem\FSO\FSOInterface;
use GI\FileSystem\FSO\Symlink\SymlinkInterface;
use GI\FileSystem\FSO\Symlink\URLHolder\Context\ContextInterface;

class URLHolder implements URLHolderInterface
{
    use ServiceLocatorAwareTrait;


    /**
     * @var FSODirInterface
     */
    private $webRoot;

    /**
     * @var string
     */
    private $rootURL = '';

    /**
     * @var SymlinkInterface
     */
    private $symlink;

    /**
     * @var string
     */
    private $url = '';


    /**
     * URLHolder constructor.
     * @param FSOInterface $target
     * @param string $path
     * @param string $webRoot
     * @param string $rootURL
     * @throws \Exception
     */
    public function __construct(FSOInterface $target, string $path, string $webRoot = '', string $rootURL = '')
    {
        /** @var ContextInterface $context */
        $context       = $this->getGiServiceLocator()->getDependency(ContextInterface::class, Context::class);
        $this->webRoot = empty($webRoot) ? $context->getWebRoot() : $webRoot;
        $this->rootURL = empty($rootURL) ? $context->getRootURL() : $rootURL;

        $this->symlink = $target->createSymlink($this->webRoot->createChildFile($path)->getPath());
        $this->url     = $this->rootURL . '/' . $path;
    }

    /**
     * @return FSODirInterface
     */
    public function getWebRoot()
    {
        return $this->webRoot;
    }

    /**
     * @param FSODirInterface $webRoot
     * @return static
     */
    protected function setWebRoot(FSODirInterface $webRoot)
    {
        $this->webRoot = $webRoot;

        return $this;
    }

    /**
     * @return string
     */
    public function getRootURL()
    {
        return $this->rootURL;
    }

    /**
     * @param string $rootURL
     * @return static
     */
    protected function setRootURL(string $rootURL)
    {
        $this->rootURL = $rootURL;

        return $this;
    }

    /**
     * @return SymlinkInterface
     */
    public function getSymlink()
    {
        return $this->symlink;
    }

    /**
     * @return static
     * @throws \Exception
     */
    public function create()
    {
        $this->getSymlink()->create();

        return $this;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @return string
     * @throws \Exception
     */
    public function getUrlWithModificationTime()
    {
        $url  = $this->url;
        $time = $this->getSymlink()->getMeta()->getModificationTime();

        $url .= (strpos($url, '?') !== false) ? '&' . $time : '?' . $time;

        return $url;
    }

    /**
     * @param int $mode
     * @return static
     */
    public function setMode(int $mode)
    {
        $this->getSymlink()->setMode($mode);

        return $this;
    }

    /**
     * @return static
     */
    public function setModeToDefault()
    {
        $this->getSymlink()->setModeToDefault();

        return $this;
    }
}