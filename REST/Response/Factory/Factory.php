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

use GI\Pattern\Factory\AbstractFactory;

use GI\REST\Response\FileResponse\Download\Download;
use GI\REST\Response\FileResponse\Excel\Excel;
use GI\REST\Response\FileResponse\GZIP\GZIP;
use GI\REST\Response\FileResponse\OctetStream\OctetStream;
use GI\REST\Response\FileResponse\PDF\PDF;
use GI\REST\Response\FileResponse\Word\Word;
use GI\REST\Response\FileResponse\ZIP\ZIP;

use GI\REST\Response\Image\GIF\GIF;
use GI\REST\Response\Image\JPEG\JPEG;
use GI\REST\Response\Image\PNG\PNG;

use GI\REST\Response\JSON\JSON;

use GI\REST\Response\Simple\Simple;

use GI\REST\Response\Status\Status;
use GI\REST\Response\Status\Status200\Status200;
use GI\REST\Response\Status\Status403\Status403;
use GI\REST\Response\Status\Status404\Status404;
use GI\REST\Response\Status\Status500\Status500;

use GI\REST\Response\Text\HTML\HTML;
use GI\REST\Response\Text\XML\XML;

use GI\REST\Response\Header\Factory\Factory as HeaderFactory;


use GI\REST\Response\ResponseInterface;

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

use GI\REST\Response\Status\StatusInterface;
use GI\REST\Response\Status\Status200\Status200Interface;
use GI\REST\Response\Status\Status403\Status403Interface;
use GI\REST\Response\Status\Status404\Status404Interface;
use GI\REST\Response\Status\Status500\Status500Interface;

use GI\REST\Response\Text\HTML\HTMLInterface;
use GI\REST\Response\Text\XML\XMLInterface;

use GI\REST\Response\Header\Factory\FactoryInterface as HeaderFactoryInterface;

/**
 * Class Factory
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
 * @method StatusInterface createStatus(int $code, $output = '', string $protocol = '')
 * @method Status200Interface createStatus200($output = '', string $protocol = '')
 * @method Status403Interface createStatus403($output = '', string $protocol = '')
 * @method Status404Interface createStatus404($output = '', string $protocol = '')
 * @method Status500Interface createStatus500($output = '', string $protocol = '')
 * @method HTMLInterface createHTML(string $text)
 * @method XMLInterface createXML(string $text)
 * @method SimpleInterface createSimple($output)
 */
class Factory extends AbstractFactory implements FactoryInterface
{
    /**
     * @var HeaderFactoryInterface
     */
    private $headerFactory;


    /**
     * Factory constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        $this->getTemplateClasses()->add(ResponseInterface::class);

        $this->set(Download::class)
            ->set(Excel::class)
            ->set(GZIP::class)
            ->set(OctetStream::class)
            ->set(PDF::class)
            ->set(Word::class)
            ->set(ZIP::class)
            ->set(GIF::class)
            ->set(JPEG::class)
            ->set(PNG::class)
            ->set(JSON::class)
            ->set(Status::class)
            ->set(Status200::class)
            ->set(Status403::class)
            ->set(Status404::class)
            ->set(Status500::class)
            ->set(HTML::class)
            ->set(XML::class)
            ->set(Simple::class);
    }

    /**
     * @return HeaderFactoryInterface
     */
    public function getHeaderFactory()
    {
        if (!($this->headerFactory instanceof HeaderFactoryInterface)) {
            $this->headerFactory = new HeaderFactory();
        }

        return $this->headerFactory;
    }
}