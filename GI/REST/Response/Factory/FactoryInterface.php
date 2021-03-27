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
namespace GI\REST\Response\Factory;

use GI\Pattern\Factory\FactoryInterface as BaseInterface;

use GI\REST\Response\FileResponse\Download\DownloadInterface;
use GI\REST\Response\FileResponse\Excel\ExcelInterface;
use GI\REST\Response\FileResponse\GZIP\GZIPInterface;
use GI\REST\Response\FileResponse\OctetStream\OctetStreamInterface;
use GI\REST\Response\FileResponse\PDF\PDFInterface;
use GI\REST\Response\FileResponse\Word\WordInterface;
use GI\REST\Response\FileResponse\ZIP\ZIPInterface;

use GI\REST\Response\Image\GIF\GIFInterface;
use GI\REST\Response\Image\JPEG\JPEGInterface;
use GI\REST\Response\Image\PNG\PNGInterface;

use GI\REST\Response\JSON\JSONInterface;

use GI\REST\Response\Simple\SimpleInterface;

use GI\REST\Response\Location\LocationInterface;

use GI\REST\Response\Refresh\RefreshInterface;

use GI\REST\Response\Status\StatusInterface;
use GI\REST\Response\Status\Status200\Status200Interface;
use GI\REST\Response\Status\Status403\Status403Interface;
use GI\REST\Response\Status\Status404\Status404Interface;
use GI\REST\Response\Status\Status500\Status500Interface;

use GI\REST\Response\Text\HTML\HTMLInterface;
use GI\REST\Response\Text\XML\XMLInterface;

use GI\REST\Response\Header\Factory\FactoryInterface as HeaderFactoryInterface;

/**
 * Interface FactoryInterface
 * @package GI\REST\Response\Factory
 *
 * @method DownloadInterface createDownload(string $file, string $contentType)
 * @method ExcelInterface createExcel(string $file)
 * @method GZIPInterface createGZIP(string $file)
 * @method OctetStreamInterface createOctetStream(string $file)
 * @method PDFInterface createPDF(string $file)
 * @method WordInterface createWord(string $file)
 * @method ZIPInterface createZIP(string $file)
 * @method GIFInterface createGIF(string $resource)
 * @method JPEGInterface createJPEG(string $resource)
 * @method PNGInterface createPNG(string $resource)
 * @method JSONInterface createJSON($data)
 * @method LocationInterface createLocation(string $url)
 * @method RefreshInterface createRefresh(int $time, string $url)
 * @method StatusInterface createStatus(int $code, $output = '', string $protocol = '')
 * @method Status200Interface createStatus200($output = '', string $protocol = '')
 * @method Status403Interface createStatus403($output = '', string $protocol = '')
 * @method Status404Interface createStatus404($output = '', string $protocol = '')
 * @method Status500Interface createStatus500($output = '', string $protocol = '')
 * @method HTMLInterface createHTML(string $text)
 * @method XMLInterface createXML(string $text)
 * @method SimpleInterface createSimple($output)
 */
interface FactoryInterface extends BaseInterface
{
    /**
     * @return HeaderFactoryInterface
     */
    public function getHeaderFactory();
}