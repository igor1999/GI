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
namespace GI\CLI\Job;

use GI\CLI\Job\Cache\Cache;

use GI\ServiceLocator\ServiceLocatorAwareTrait;

use GI\CLI\Job\Cache\CacheInterface;
use GI\CLI\Job\Cache\JobData\JobDataInterface;

abstract class AbstractJob implements JobInterface
{
    use ServiceLocatorAwareTrait;


    /**
     * @var CacheInterface
     */
    private static $sessionCache;

    /**
     * @var string
     */
    private $id = '';


    /**
     * AbstractJob constructor.
     * @param string $id
     * @throws \Exception
     */
    public function __construct(string $id = '')
    {
        if ($this->giGetServiceLocator()->isCLI()) {
            $this->id = empty($id) ? $this->giGetCommandLine()->getJob() : $id;

            try {
                $this->getDataContainer();
            } catch (\Exception $exception) {
                self::$sessionCache->add($this->id, $this->createDataContainer());
            }

            $this->start();
        } else {
            if (empty($id)) {
                $this->giThrowIsEmptyException('Job id');
            }

            $this->id = $id;
        }
    }

    /**
     * @return string
     */
    public static function getDefaultSessionCacheClass()
    {
        return Cache::class;
    }

    /**
     * @return string
     */
    protected function getId()
    {
        return $this->id;
    }

    /**
     * @return JobDataInterface
     * @throws \Exception
     */
    protected function getDataContainer()
    {
        return self::$sessionCache->get($this->id);
    }

    /**
     * @return JobDataInterface
     */
    abstract protected function createDataContainer();

    /**
     * @return bool
     * @throws \Exception
     */
    public function isDone()
    {
        return $this->getDataContainer()->isDone();
    }

    /**
     * @return static
     */
    abstract protected function start();

    /**
     * @return static
     * @throws \Exception
     */
    protected function save()
    {
        $this->giGetServiceLocator()->saveSession();

        return $this;
    }

    /**
     * @return static
     */
    protected function restart()
    {
        $this->giGetServiceLocator()->getCommandLine()->getExecutionProcessor()->startBackgroundProcess();

        return $this;
    }

    /**
     * @return static
     * @throws \Exception
     */
    protected function saveAndRestart()
    {
        $this->save()->restart();

        return $this;
    }
}