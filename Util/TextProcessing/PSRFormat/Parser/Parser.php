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

use GI\Util\TextProcessing\PSRFormat\AbstractPrefix;

/**
 * Class Parser
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
class Parser extends AbstractPrefix implements ParserInterface
{
    /**
     * @param string $source
     * @param string $prefix
     * @param bool $lcFirst
     * @return string
     * @throws \Exception
     */
    public function parseAfterPrefix(string $source, string $prefix, bool $lcFirst = true)
    {
        if (strpos($source, $prefix) !== 0) {
            $this->giThrowCommonException('Prefix \'%s\' in source \'%s\' not found', [$prefix, $source]);
        }

        $result = substr($source, strlen($prefix));

        if ($lcFirst) {
            $result = lcfirst($result);
        }

        return $result;
    }

    /**
     * @param string $source
     * @param string $suffix
     * @param bool $lcFirst
     * @return string
     * @throws \Exception
     */
    public function parseBeforeSuffix(string $source, string $suffix, bool $lcFirst = true)
    {
        $result = strstr($source, $suffix, true);

        if ($result === false) {
            $this->giThrowCommonException('Suffix \'%s\' in source \'%s\' not found', [$suffix, $source]);
        }

        if ($lcFirst) {
            $result = lcfirst($result);
        }

        return $result;
    }

    /**
     * @param string $source
     * @param string $prefix
     * @param string $suffix
     * @param bool $lcFirst
     * @return string
     * @throws \Exception
     */
    public function parseMiddle(string $source, string $prefix, string $suffix, bool $lcFirst = true)
    {
        $result = $this->parseAfterPrefix($source, $prefix, $lcFirst);

        return $this->parseBeforeSuffix($result, $suffix, $lcFirst);
    }

    /**
     * @param string $method
     * @param array $arguments
     * @return bool|string
     * @throws \Exception
     */
    public function __call(string $method, array $arguments = [])
    {
        $prefix = $this->parseAfterPrefix($method, self::METHOD_PARSE_WITH_PREFIX);

        $this->validatePrefix($prefix, $method);

        if (empty($arguments)) {
            $this->giThrowNotGivenException('Source for parsing');
        }

        $source  = array_shift($arguments);

        if (empty($arguments)) {
            $result = $this->parseAfterPrefix($source, $prefix);
        } else {
            $suffix = array_shift($arguments);
            $lcFirst = empty($arguments) ? true : array_shift($arguments);

            $result = empty($suffix)
                ? $this->parseAfterPrefix($source, $prefix, $lcFirst)
                : $this->parseMiddle($source, $prefix, $suffix, $lcFirst);
        }

        return $result;
    }

    /**
     * @param string $source
     * @param string $suffix
     * @param bool $lcFirst
     * @return string
     */
    public function parseWithPrefixesGetAndIs(string $source, string $suffix = '', bool $lcFirst = true)
    {
        try {
            $result = $this->parseWithPrefixGet($source, $suffix, $lcFirst);
        } catch (\Exception $exception) {
            $result = $this->parseWithPrefixIs($source, $suffix, $lcFirst);
        }

        return $result;
    }

    /**
     * @param string $source
     * @param string $separator
     * @param mixed $defaultFirst
     * @param mixed $defaultSecond
     * @return array
     */
    public function getSeparatedParts(string $source, string $separator, $defaultFirst = null, $defaultSecond = null)
    {
        if (strpos($source, $separator) !== false) {
            list($first, $second) = explode($separator, $source, 2);
        } else {
            $first  = $defaultFirst;
            $second = $defaultSecond;
        }

        return [$first, $second];
    }

    /**
     * @param string $source
     * @return string[]
     * @throws \Exception
     */
    public function parseBoolGetterWithValue(string $source)
    {
        $propertyAndValue = $this->parseWithPrefixIs($source);

        list($property, $value) = $this->getSeparatedParts(
            $propertyAndValue, self::BOOL_GETTER_VALUE_SEPARATOR
        );

        if (empty($property) || empty($value)) {
            $this->giThrowInvalidFormatException('Bool getter with value', $source, 'isPropertyEqualValue');
        }

        return [$property, lcfirst($value)];
    }

    /**
     * @param string $source
     * @return string[]
     * @throws \Exception
     */
    public function parseSetterWithValue(string $source)
    {
        $propertyAndValue = $this->parseWithPrefixSet($source);

        list($property, $value) = $this->getSeparatedParts($propertyAndValue, self::SETTER_VALUE_SEPARATOR);

        if (empty($property) || empty($value)) {
            $this->giThrowInvalidFormatException('Setter with value', $source, 'setPropertyToValue');
        }

        return [$property, lcfirst($value)];
    }

    /**
     * @param string $source
     * @param string $prefix
     * @return array
     * @throws \Exception
     */
    public function parseWithArgumentList(string $source, string $prefix)
    {
        $propertyAndArgumentList = $this->parseAfterPrefix($source, $prefix);

        list($property, $argumentList) = $this->getSeparatedParts(
            $propertyAndArgumentList, self::PROPERTY_AND_ARGUMENT_LIST_SEPARATOR
        );

        if (empty($property) || empty($argumentList)) {
            $this->giThrowInvalidFormatException(
                'Argument list', $source, '[prefix]PropertyWithValue1AndValue2...'
            );
        }

        $f = function($param)
        {
            return lcfirst($param);
        };
        $argumentList = explode(self::ARGUMENT_LIST_SEPARATOR, $argumentList);
        $argumentList = array_map($f, $argumentList);

        return [$property, $argumentList];
    }

    /**
     * @param string $source
     * @return string[]
     * @throws \Exception
     */
    public function parseCreateWithArgumentList(string $source)
    {
        return $this->parseWithArgumentList($source, self::PREFIX_CREATE);
    }

    /**
     * @param string $source
     * @return string[]
     * @throws \Exception
     */
    public function parseBuildWithArgumentList(string $source)
    {
        return $this->parseWithArgumentList($source, self::PREFIX_BUILD);
    }

    /**
     * @param string $source
     * @return string[]
     * @throws \Exception
     */
    public function parseExecuteWithArgumentList(string $source)
    {
        return $this->parseWithArgumentList($source, self::PREFIX_EXECUTE);
    }
}