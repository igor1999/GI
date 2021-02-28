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
namespace GI\Util\TextProcessing\Escaper\HTMLText;

use GI\Util\TextProcessing\Escaper\AbstractEscaper;

use GI\Util\TextProcessing\Encoding\EncodingTrait;

class Escaper extends AbstractEscaper implements EscaperInterface
{
    use EncodingTrait;


    const ESCAPE_FLAGS   = ENT_QUOTES | ENT_SUBSTITUTE;

    const UNESCAPE_FLAGS = ENT_QUOTES;


    /**
     * Escaper constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        $this->initEncodingByContext();
    }

    /**
     * @param string $string
     * @return string
     */
    public function escape(string $string)
    {
        return $this->isOn() ? htmlspecialchars($string, static::ESCAPE_FLAGS, $this->getEncoding()) : $string;
    }

    /**
     * @param string $string
     * @return string
     */
    public function unescape(string $string)
    {
        return html_entity_decode($string, static::UNESCAPE_FLAGS, $this->getEncoding());
    }
}