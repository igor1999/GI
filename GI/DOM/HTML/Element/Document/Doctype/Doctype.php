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
namespace GI\DOM\HTML\Element\Document\Doctype;

use GI\DOM\Base\Element\AbstractElement;

class Doctype extends AbstractElement implements DoctypeInterface
{
    const TAG = 'DOCTYPE';


    const DEFAULT_CONTENTS = 'html';


    /**
     * @var string
     */
    private $contents = '';


    /**
     * Doctype constructor.
     *
     * @param string $contents
     */
    public function __construct(string $contents = self::DEFAULT_CONTENTS)
    {
        parent::__construct(static::TAG);

        $this->contents = $contents;
    }

    /**
     * @return string
     */
    protected function getTagTemplate()
    {
        return '<!%s %s>';
    }

    /**
     * @return string
     */
    public function getContents()
    {
        return $this->contents;
    }

    /**
     * @param string $contents
     * @return static
     */
    public function setContents(string $contents)
    {
        $this->contents = $contents;

        return $this;
    }
}