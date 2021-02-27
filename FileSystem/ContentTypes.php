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
namespace GI\FileSystem;

use GI\ServiceLocator\ServiceLocatorAwareTrait;

class ContentTypes
{
    use ServiceLocatorAwareTrait;


    const SEPARATOR = '/';


    const CSS          = 'text/css';

    const EXCEL        = 'application/excel';

    const GZIP         = 'application/gzip';

    const GIF          = 'image/gif';

    const HTML         = 'text/html';

    const JPEG         = 'image/jpeg';

    const JPG          = 'image/jpg';

    const JS           = 'text/javascript';

    const JSON         = 'text/json';

    const PNG          = 'image/png';

    const OCTET_STREAM = 'application/octet-stream';

    const PDF          = 'application/pdf';

    const TEXT         = 'text/plain';

    const WORD         = 'application/word';

    const XML          = 'text/xml';

    const ZIP          = 'application/zip';
}