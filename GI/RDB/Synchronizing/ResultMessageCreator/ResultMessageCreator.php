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
namespace GI\RDB\Synchronizing\ResultMessageCreator;

use GI\RDB\Synchronizing\ResultMessageCreator\Context\Context;

use GI\ServiceLocator\ServiceLocatorAwareTrait;

use GI\RDB\Synchronizing\ResultMessageCreator\Context\ContextInterface;

class ResultMessageCreator implements ResultMessageCreatorInterface
{
    use ServiceLocatorAwareTrait;


    const DUMP_TITLE            = 'OK:';

    const DUMP_MESSAGE_TEMPLATE = 'dump created in file \'%s\'';


    const NO_DIFF_TITLE   = 'OK:';

    const NO_DIFF_MESSAGE = 'no differences found';


    const DIFF_TITLE          = 'Difference(s):';

    const DUMP_ONLY_TITLE     = '"dump-only" tables';

    const DATABASE_ONLY_TITLE = '"database-only" tables';

    const UNEQUAL_TITLE       = '"unequal" tables';


    const ERROR_TITLE = 'Error:';


    const MESSAGE_TEMPLATE = '%1$s %2$s';


    /**
     * @var ContextInterface
     */
    private $context;

    /**
     * @var string
     */
    private $message = '';


    /**
     * Output constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        $this->context = $this->getGiServiceLocator()->getDependency(ContextInterface::class, Context::class);
    }

    /**
     * @return ContextInterface
     */
    protected function getContext()
    {
        return $this->context;
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param string $message
     * @return static
     */
    protected function setMessage(string $message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * @param string $path
     * @return static
     */
    public function createDump(string $path)
    {
        $this->create(
            static::DUMP_TITLE,
            sprintf(static::DUMP_MESSAGE_TEMPLATE, $path),
            $this->getContext()->getDumpForeground(),
            $this->getContext()->getDumpBackground()
        );

        return $this;
    }

    /**
     * @return static
     */
    public function createNoDiff()
    {
        $this->create(
            static::NO_DIFF_TITLE,
            static::NO_DIFF_MESSAGE,
            $this->getContext()->getNoDiffForeground(),
            $this->getContext()->getNoDiffBackground()
        );

        return $this;
    }

    /**
     * @param int $countOfDumpOnly
     * @param int $countOfDatabaseOnly
     * @param int $countOfUnequals
     * @return static
     */
    public function createDiff(int $countOfDumpOnly, int $countOfDatabaseOnly, int $countOfUnequals)
    {
        $messages = [
            [$countOfDumpOnly, static::DUMP_ONLY_TITLE],
            [$countOfDatabaseOnly, static::DATABASE_ONLY_TITLE],
            [$countOfUnequals, static::UNEQUAL_TITLE],
        ];

        $f = function(array $contents)
        {
            return $contents[0] > 0;
        };
        $messages = array_filter($messages, $f);

        $f = function(array $contents)
        {
            return $contents[0] . ' ' . $contents[1];
        };
        $messages = array_map($f, $messages);

        $message = implode(', ', $messages);

        $this->create(
            static::DIFF_TITLE,
            $message,
            $this->getContext()->getDiffForeground(),
            $this->getContext()->getDiffBackground()
        );

        return $this;
    }

    /**
     * @param string $message
     * @return static
     */
    public function createError(string $message)
    {
        $this->create(
            static::ERROR_TITLE,
            $message,
            $this->getContext()->getErrorForeground(),
            $this->getContext()->getErrorBackground()
        );

        return $this;
    }

    /**
     * @param string $title
     * @param string $message
     * @param string $foregroundColor
     * @param string $backgroundColor
     * @return static
     */
    protected function create(string $title, string $message, string $foregroundColor, string $backgroundColor)
    {
        $title = $this->getGiServiceLocator()->getCliFactory()->createColorizing()->colorize(
            $title, $foregroundColor, $backgroundColor
        );

        $text = sprintf(static::MESSAGE_TEMPLATE, $title, $message);

        $this->setMessage($text);

        return $this;
    }
}