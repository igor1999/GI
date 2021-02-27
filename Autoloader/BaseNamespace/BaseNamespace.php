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
namespace GI\Autoloader\BaseNamespace;

class BaseNamespace implements BaseNamespaceInterface
{
    const DEFAULT_EXTENSION = 'php';


    /**
     * @var string
     */
    private $baseNamespace = '';

    /**
     * @var string
     */
    private $baseDirectory = '';

    /**
     * @var int|\Closure
     */
    private $psr;

    /**
     * @var string
     */
    private $extension = '';


    /**
     * BaseNamespace constructor.
     * @param string $baseNamespace
     * @param string $baseDirectory
     * @param int|\Closure|null $psr
     * @param string|null $extension
     */
    public function __construct(string $baseNamespace, string $baseDirectory, $psr = null, string $extension = null)
    {
        if (!is_dir($baseDirectory)) {
            trigger_error('Directory not found: ' . $baseDirectory, E_USER_ERROR);
        }

        if (empty($psr)) {
            $psr = self::PSR4;
        }

        if (!in_array($psr, [self::PSR0, self::PSR4]) && !($psr instanceof \Closure)) {
            trigger_error('PSR should be a number or closure: ' . $psr, E_USER_ERROR);
        }

        if (empty($extension)) {
            $extension = static::DEFAULT_EXTENSION;
        }

        $this->baseNamespace = $baseNamespace;
        $this->baseDirectory = $baseDirectory;
        $this->psr           = $psr;
        $this->extension     = $extension;
    }

    /**
     * @return string
     */
    public function getBaseNamespace()
    {
        return $this->baseNamespace;
    }

    /**
     * @return string
     */
    public function getBaseDirectory()
    {
        return $this->baseDirectory;
    }

    /**
     * @return \Closure|int
     */
    public function getPsr()
    {
        return $this->psr;
    }

    /**
     * @return string
     */
    public function getExtension()
    {
        return $this->extension;
    }

    /**
     * @return bool
     */
    public function isPsr4()
    {
        return !$this->isPsrClosure() && ($this->psr == self::PSR4);
    }

    /**
     * @return bool
     */
    public function isPsr0()
    {
        return !$this->isPsrClosure() && ($this->psr == self::PSR0);
    }

    /**
     * @return bool
     */
    public function isPsrClosure()
    {
        return ($this->psr instanceof \Closure);
    }

    /**
     * @param string $class
     * @return string|bool
     */
    public function createFile(string $class)
    {
        if (empty($this->baseNamespace) || (strpos($class, $this->baseNamespace) === 0)) {
            switch (true) {
                case $this->isPsr4():
                    $extendedName = substr($class, strlen($this->baseNamespace));
                    $extendedPath = str_replace('\\', '/', $extendedName) . '.' . $this->extension;
                    break;
                case $this->isPsr0():
                    $extendedPath = str_replace(['\\', '_'], ['/', '/'], $class) . '.' . $this->extension;
                    break;
                case $this->isPsrClosure():
                    $extendedPath = call_user_func($this->psr, $class);
                    break;
                default:
                    $extendedPath = '';
                    break;
            }

            $file = empty($extendedPath) ? false : $this->baseDirectory . '/' . $extendedPath;
        } else {
            $file = false;
        }

        return $file;
    }
}