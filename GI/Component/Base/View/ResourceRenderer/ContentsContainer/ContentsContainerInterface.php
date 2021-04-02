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

interface ContentsContainerInterface
{
    /**
     * @return string
     */
    public function getTargetClass();

    /**
     * @param string $targetClass
     * @return static
     */
    public function setTargetClass(string $targetClass);

    /**
     * @return string
     */
    public function getTargetRelativeDir();

    /**
     * @param string $targetRelativeDir
     * @return static
     */
    public function setTargetRelativeDir(string $targetRelativeDir);

    /**
     * @return string
     */
    public function getUrlDir();

    /**
     * @param string $urlDir
     * @return static
     */
    public function setUrlDir(string $urlDir);

    /**
     * @return array
     */
    public function getCss();

    /**
     * @param array $css
     * @return static
     */
    public function setCss(array $css);

    /**
     * @return array
     */
    public function getJs();

    /**
     * @param array $js
     * @return static
     */
    public function setJs(array $js);

    /**
     * @return array
     */
    public function getImages();

    /**
     * @param array $images
     * @return static
     */
    public function setImages(array $images);

    /**
     * @return static
     */
    public function clean();
}