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
namespace GI\Util\TextProcessing\PSRFormat;

interface PrefixInterface
{
    const PREFIX_HAS               = 'has';

    const PREFIX_GET               = 'get';

    const PREFIX_IS                = 'is';

    const PREFIX_SET               = 'set';

    const PREFIX_ADD               = 'add';

    const PREFIX_INSERT            = 'insert';

    const PREFIX_CREATE            = 'create';

    const PREFIX_CREATE_AND_ADD    = 'createAndAdd';

    const PREFIX_CREATE_AND_INSERT = 'createAndInsert';

    const PREFIX_RENDER            = 'render';

    const PREFIX_PARSE             = 'parse';

    const PREFIX_BUILD             = 'build';

    const PREFIX_REMOVE            = 'remove';

    const PREFIX_DELETE            = 'delete';

    const PREFIX_EXECUTE           = 'execute';


    const PREFIX_OF_PREFIX_CONSTANTS = 'PREFIX_';
}