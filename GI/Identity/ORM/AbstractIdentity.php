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
namespace GI\Identity\ORM;

use GI\Identity\AbstractIdentity as Base;
use GI\Identity\ORM\Record\Record as EmptyRecord;

use GI\Identity\Exception\ExceptionAwareTrait;

use GI\RDB\ORM\Record\RecordInterface;
use GI\Identity\ORM\Record\RecordInterface as EmptyRecordInterface;

abstract class AbstractIdentity extends Base implements IdentityInterface
{
    use ExceptionAwareTrait;


    /**
     * @return string
     */
    public static function getDefaultSessionCacheClass()
    {
        return EmptyRecord::class;
    }

    /**
     * @return RecordInterface
     */
    abstract protected function getSessionCache();

    /**
     * @return EmptyRecordInterface
     */
    protected function createEmptyRecord()
    {
        try {
           $record = $this->giGetDi(EmptyRecordInterface::class);
        } catch (\Exception $exception) {
            $record = new EmptyRecord();
        }

        return $record;
    }

    /**
     * @param string $login
     * @param string $password
     * @return RecordInterface
     */
    abstract protected function createByCredentials(string $login, string $password);

    /**
     * @param int $id
     * @return RecordInterface
     */
    abstract protected function createByUserID(int $id);

    /**
     * @param mixed $data
     * @param bool $saveInCookie
     * @return static
     * @throws \Exception
     */
    protected function set($data, bool $saveInCookie = false)
    {
        $this->setRecord($data)->setCookie($saveInCookie);

        return $this;
    }

    /**
     * @param RecordInterface $data
     * @return static
     * @throws \Exception
     */
    abstract protected function setRecord(RecordInterface $data);

    /**
     * @return static
     * @throws \Exception
     */
    protected function cleanCache()
    {
        $this->setRecord($this->createEmptyRecord());

        return $this;
    }

    /**
     * @return bool
     */
    public function isAuthenticated()
    {
        return ($this->getSessionCache() instanceof RecordInterface)
            && !($this->getSessionCache() instanceof EmptyRecordInterface);
    }
}