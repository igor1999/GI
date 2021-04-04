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
namespace GI\Component\Base\View\ResourceRenderer\ClassContents;

use GI\ServiceLocator\ServiceLocatorAwareTrait;

class ClassContents implements ClassContentsInterface
{
    use ServiceLocatorAwareTrait;


    /**
     * @var string
     */
    private $targetClass;

    /**
     * @var string
     */
    private $targetRelativeDir = '';

    /**
     * @var string
     */
    private $urlBaseDir = '';

    /**
     * @var array
     */
    private $cssPaths = [];

    /**
     * @var array
     */
    private $jsPaths = [];

    /**
     * @var array
     */
    private $imagePaths = [];


    /**
     * ClassContents constructor.
     * @param string $targetClass
     * @throws \Exception
     */
    public function __construct(string $targetClass)
    {
        $this->targetClass = $targetClass;

        $constants = $this->giGetClassMeta($this->targetClass)->getSelfConstants();

        try {
            $this->targetRelativeDir = $constants->get('TARGET_RELATIVE_DIR')->getValue();
        } catch (\Exception $exception) {}

        try {
            $this->urlBaseDir = $constants->get('URL_BASE_DIR')->getValue();
        } catch (\Exception $exception) {}

        try {
            $this->cssPaths = $constants->get('CSS_PATHS')->getValue();
        } catch (\Exception $exception) {}

        try {
            $this->jsPaths = $constants->get('JS_PATHS')->getValue();
        } catch (\Exception $exception) {}

        try {
            $this->imagePaths = $constants->get('IMAGE_PATHS')->getValue();
        } catch (\Exception $exception) {}
    }

    /**
     * @return string
     */
    public function getTargetClass()
    {
        return $this->targetClass;
    }

    /**
     * @return string
     */
    public function getTargetRelativeDir()
    {
        return $this->targetRelativeDir;
    }

    /**
     * @return string
     */
    public function getUrlBaseDir()
    {
        return $this->urlBaseDir;
    }

    /**
     * @return array
     */
    public function getCssPaths()
    {
        return $this->cssPaths;
    }

    /**
     * @return array
     */
    public function getJsPaths()
    {
        return $this->jsPaths;
    }

    /**
     * @return array
     */
    public function getImagePaths()
    {
        return $this->imagePaths;
    }

    /**
     * @return static
     * @throws \Exception
     */
    public function validate()
    {
        if (empty($this->urlBaseDir)) {
            $this->giThrowIsEmptyException('URl Dir');
        }

        return $this;
    }
}