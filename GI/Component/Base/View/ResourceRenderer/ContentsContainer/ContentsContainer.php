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
namespace GI\Component\Base\View\ResourceRenderer\ContentsContainer;

use GI\ServiceLocator\ServiceLocatorAwareTrait;

class ContentsContainer implements ContentsContainerInterface
{
    use ServiceLocatorAwareTrait;


    /**
     * @var string
     */
    private $targetClass = '';

    /**
     * @var string
     */
    private $targetRelativeDir = '';

    /**
     * @var string
     */
    private $urlDir;

    /**
     * @var array
     */
    private $css = [];

    /**
     * @var array
     */
    private $js = [];

    /**
     * @var array
     */
    private $images = [];


    /**
     * ContentsContainer constructor.
     * @param string $urlDir
     */
    public function __construct(string $urlDir)
    {
        $this->urlDir = $urlDir;
    }

    /**
     * @return string
     */
    public function getTargetClass()
    {
        return $this->targetClass;
    }

    /**
     * @param string $targetClass
     * @return static
     */
    public function setTargetClass(string $targetClass)
    {
        $this->targetClass = $targetClass;

        return $this;
    }

    /**
     * @return string
     */
    public function getTargetRelativeDir()
    {
        return $this->targetRelativeDir;
    }

    /**
     * @param string $targetRelativeDir
     * @return static
     */
    public function setTargetRelativeDir(string $targetRelativeDir)
    {
        $this->targetRelativeDir = $targetRelativeDir;

        return $this;
    }

    /**
     * @return string
     */
    public function getUrlDir()
    {
        return $this->urlDir;
    }

    /**
     * @param string $urlDir
     * @return static
     */
    public function setUrlDir(string $urlDir)
    {
        $this->urlDir = $urlDir;

        return $this;
    }

    /**
     * @return array
     */
    public function getCss()
    {
        return $this->css;
    }

    /**
     * @param array $css
     * @return static
     */
    public function setCss(array $css)
    {
        $this->css = $css;

        return $this;
    }

    /**
     * @return array
     */
    public function getJs()
    {
        return $this->js;
    }

    /**
     * @param array $js
     * @return static
     */
    public function setJs(array $js)
    {
        $this->js = $js;

        return $this;
    }

    /**
     * @return array
     */
    public function getImages()
    {
        return $this->images;
    }

    /**
     * @param array $images
     * @return static
     */
    public function setImages(array $images)
    {
        $this->images = $images;

        return $this;
    }

    /**
     * @return static
     */
    public function clean()
    {
        $this->setTargetClass('')
            ->setTargetRelativeDir('')
            ->setUrlDir('')
            ->setCss([])
            ->setJs([])
            ->setImages([]);

        return $this;
    }
}