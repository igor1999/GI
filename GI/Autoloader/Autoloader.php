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
namespace GI\Autoloader;

use GI\Autoloader\BaseNamespace\BaseNamespace;

use GI\Autoloader\BaseNamespace\BaseNamespaceInterface;

class Autoloader implements AutoloaderInterface
{
    /**
     * @var BaseNamespaceInterface[]
     */
    private $baseNamespaces = [];

    /**
     * @var bool
     */
    private $dieIfNotFound = true;


    /**
     * Autoloader constructor.
     */
    public function __construct()
    {
        $f = function($class)
        {
            $this->autoload($class);
        };
        spl_autoload_register($f);

        $this->addBaseNamespace('GI', dirname(__DIR__));
    }

    /**
     * @return bool
     */
    public function isDieIfNotFound()
    {
        return $this->dieIfNotFound;
    }

    /**
     * @param bool $dieIfNotFound
     * @return static
     */
    public function setDieIfNotFound(bool $dieIfNotFound)
    {
        $this->dieIfNotFound = $dieIfNotFound;

        return $this;
    }

    /**
     * @param string $baseNamespace
     * @param string $baseDirectory
     * @param \Closure|int|null $psr
     * @param string|null $extension
     * @return static
     */
    public function addBaseNamespace(
        string $baseNamespace, string $baseDirectory, $psr = null, string $extension = null)
    {
        $this->baseNamespaces[] = $this->createBaseNamespace($baseNamespace, $baseDirectory, $psr, $extension);

        return $this;
    }

    /**
     * @param string $baseNamespace
     * @param string $baseDirectory
     * @param \Closure|int|null $psr
     * @param string|null $extension
     * @return BaseNamespace
     */
    protected function createBaseNamespace(
        string $baseNamespace, string $baseDirectory, $psr = null, string $extension = null)
    {
        return new BaseNamespace($baseNamespace, $baseDirectory, $psr, $extension);
    }

    /**
     * @param string $class
     */
    protected function autoload(string $class)
    {
        if (!$this->doAutoload($class) && $this->dieIfNotFound) {
            trigger_error('Class not found: ' . $class, E_USER_ERROR);
        }
    }

    /**
     * @param string $class
     * @return bool
     */
    protected function doAutoload(string $class)
    {
        $found = false;

        foreach ($this->baseNamespaces as $baseNamespace) {
            $file = $baseNamespace->createFile($class);

            if (($file !== false) && is_file($file)) {
                /** @noinspection PhpIncludeInspection */
                include_once $file;

                $found = true;
                break;
            }
        }

        return $found;
    }
}