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
namespace GI\Util\TextProcessing\PSRFormat\Parser;

use GI\Util\TextProcessing\PSRFormat\PrefixInterface;

/**
 * interface ParserInterface
 * @package GI\Util\TextProcessing\PSRFormat\Parser
 *
 * @method parseWithPrefixHas(string $source, string $suffix = '', bool $lcFirst = true)
 * @method parseWithPrefixGet(string $source, string $suffix = '', bool $lcFirst = true)
 * @method parseWithPrefixIs(string $source, string $suffix = '', bool $lcFirst = true)
 * @method parseWithPrefixSet(string $source, string $suffix = '', bool $lcFirst = true)
 * @method parseWithPrefixAdd(string $source, string $suffix = '', bool $lcFirst = true)
 * @method parseWithPrefixInsert(string $source, string $suffix = '', bool $lcFirst = true)
 * @method parseWithPrefixCreate(string $source, string $suffix = '', bool $lcFirst = true)
 * @method parseWithPrefixCreateAndAdd(string $source, string $suffix = '', bool $lcFirst = true)
 * @method parseWithPrefixCreateAndInsert(string $source, string $suffix = '', bool $lcFirst = true)
 * @method parseWithPrefixRender(string $source, string $suffix = '', bool $lcFirst = true)
 * @method parseWithPrefixParse(string $source, string $suffix = '', bool $lcFirst = true)
 * @method parseWithPrefixBuild(string $source, string $suffix = '', bool $lcFirst = true)
 * @method parseWithPrefixRemove(string $source, string $suffix = '', bool $lcFirst = true)
 * @method parseWithPrefixDelete(string $source, string $suffix = '', bool $lcFirst = true)
 * @method parseWithPrefixExecute(string $source, string $suffix = '', bool $lcFirst = true)
 */
interface ParserInterface extends PrefixInterface
{
    const METHOD_PARSE_WITH_PREFIX = 'parseWithPrefix';


    const SETTER_VALUE_SEPARATOR      = 'To';

    const BOOL_GETTER_VALUE_SEPARATOR = 'Equal';


    const PROPERTY_AND_ARGUMENT_LIST_SEPARATOR = 'With';

    const ARGUMENT_LIST_SEPARATOR              = 'And';


    /**
     * @param string $source
     * @param string $prefix
     * @param bool $lcFirst
     * @return string
     * @throws \Exception
     */
    public function parseAfterPrefix(string $source, string $prefix, bool $lcFirst = true);

    /**
     * @param string $source
     * @param string $suffix
     * @param bool $lcFirst
     * @return string
     * @throws \Exception
     */
    public function parseBeforeSuffix(string $source, string $suffix, bool $lcFirst = true);

    /**
     * @param string $source
     * @param string $prefix
     * @param string $suffix
     * @param bool $lcFirst
     * @return string
     * @throws \Exception
     */
    public function parseMiddle(string $source, string $prefix, string $suffix, bool $lcFirst = true);

    /**
     * @param string $source
     * @param string $suffix
     * @param bool $lcFirst
     * @return string
     * @throws \Exception
     */
    public function parseWithPrefixesGetAndIs(string $source, string $suffix = '', bool $lcFirst = true);

    /**
     * @param string $source
     * @param string $separator
     * @param mixed $defaultFirst
     * @param mixed $defaultSecond
     * @return array
     */
    public function getSeparatedParts(string $source, string $separator, $defaultFirst = null, $defaultSecond = null);

    /**
     * @param string $source
     * @return string[]
     * @throws \Exception
     */
    public function parseBoolGetterWithValue(string $source);

    /**
     * @param string $source
     * @return string[]
     * @throws \Exception
     */
    public function parseSetterWithValue(string $source);

    /**
     * @param string $source
     * @param string $prefix
     * @return string[]
     * @throws \Exception
     */
    public function parseWithArgumentList(string $source, string $prefix);

    /**
     * @param string $source
     * @return string[]
     * @throws \Exception
     */
    public function parseCreateWithArgumentList(string $source);

    /**
     * @param string $source
     * @return array
     * @throws \Exception
     */
    public function parseBuildWithArgumentList(string $source);

    /**
     * @param string $source
     * @return string[]
     * @throws \Exception
     */
    public function parseExecuteWithArgumentList(string $source);
}