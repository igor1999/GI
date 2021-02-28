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
namespace GI\DOM\HTML\Element\Document\Meta\Charset;

use GI\DOM\HTML\Element\Document\Meta\Meta;
use GI\DOM\HTML\Attributes\Attributes;

use GI\DOM\HTML\Attributes\AttributesInterface;

class Charset extends Meta implements CharsetInterface
{
    /**
     * @var string
     */
    private $charset = self::DEFAULT_CHARSET;

    /**
     * @var AttributesInterface
     */
    private $attributes;


    /**
     * Charset constructor.
     *
     * @param string $charset
     */
    public function __construct(string $charset = self::DEFAULT_CHARSET)
    {
        parent::__construct();

        $this->charset = $charset;
    }

    /**
     * @return static
     * @throws \Exception
     */
    protected function createAttributes()
    {
        $this->attributes = $this->giGetDi(
            AttributesInterface::class, Attributes::class, [['charset' => $this->charset]]
        );

        return $this;
    }

    /**
     * @return AttributesInterface
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

    /**
     * @return string
     */
    public function getCharset()
    {
        return $this->charset;
    }
}