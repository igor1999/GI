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
namespace GI\Application\Call\Web;

use GI\Application\Call\CallInterface as BaseInterface;
use GI\REST\Request\Factory\FactoryInterface as RequestFactoryInterface;
use GI\REST\Response\ResponseInterface;

/**
 * Interface CallInterface
 * @package GI\Application\Call\Web
 *
 * @method CallInterface setResponseToDownload(string $file, string $contentType)
 * @method CallInterface setResponseToExcel(string $file)
 * @method CallInterface setResponseToGZIP(string $file)
 * @method CallInterface setResponseToOctetStream(string $file)
 * @method CallInterface setResponseToPDF(string $file)
 * @method CallInterface setResponseToWord(string $file)
 * @method CallInterface setResponseToZIP(string $file)
 * @method CallInterface setResponseToGIF($resource)
 * @method CallInterface setResponseToJPEG($resource)
 * @method CallInterface setResponseToPNG($resource)
 * @method CallInterface setResponseToJSON($data)
 * @method CallInterface setResponseToLocation(string $url)
 * @method CallInterface setResponseToRefresh(int $time, string $url)
 * @method CallInterface setResponseToStatus200(string $output = '', string $protocol = '')
 * @method CallInterface setResponseToStatus403(string $output = '', string $protocol = '')
 * @method CallInterface setResponseToStatus404(string $output = '', string $protocol = '')
 * @method CallInterface setResponseToStatus500(string $output = '', string $protocol = '')
 * @method CallInterface setResponseToHTML(string $text)
 * @method CallInterface setResponseToXML(string $text)
 * @method CallInterface setResponseToSimple($output)
 */
interface CallInterface extends BaseInterface
{
    const SET_RESPONSE_METHOD_PREFIX = 'setResponseTo';


    /**
     * @return RequestFactoryInterface
     */
    public function getRequest();

    /**
     * @return ResponseInterface
     */
    public function getResponse();

    /**
     * @param ResponseInterface $response
     * @return static
     */
    public function setResponse(ResponseInterface $response);

    /**
     * @return bool
     * @throws \Exception
     */
    public function handle();
}