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
namespace GI\Util\TextProcessing\Escaper;

use GI\Util\TextProcessing\Encoding\EncodingTrait;

abstract class AbstractAttributeEscaper extends AbstractEscaper implements AttributeEscaperInterface
{
    use EncodingTrait;


    /**
     * AbstractAttributeEscaper constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        $this->initEncodingByContext();
    }

    /**
     * @param string $string
     * @return string
     * @throws \Exception
     */
    public function escape(string $string)
    {
        $encoder = $this->getGiServiceLocator()->getUtilites()->getEncoder();

        $result = $encoder->toUTF8($string, $this->getEncoding());

        $f = function(array $matches)
        {
            return $this->escapeChar($matches[0]);
        };
        $result = preg_replace_callback($this->getMatchAttributeRegExp(), $f, $result);

        $result = $encoder->fromUTF8($result, $this->getEncoding());

        return $result;
    }

    /**
     * @param string $char
     * @return string
     */
    abstract protected function escapeChar(string $char);

    /**
     * @return string
     */
    abstract protected function getMatchAttributeRegExp();
}