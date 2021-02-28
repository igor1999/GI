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
namespace GI\REST\Route\Factory;

use GI\Pattern\Factory\AbstractFactory;

use GI\REST\Route\Simple\Method\Delete\Delete as DeleteMethod;
use GI\REST\Route\Simple\Method\Get\Get as GetMethod;
use GI\REST\Route\Simple\Method\Post\Post as PostMethod;
use GI\REST\Route\Simple\Method\Put\Put as PutMethod;

use GI\REST\Route\Simple\Protocol\HTTP\HTTP as HTTPProtocol;
use GI\REST\Route\Simple\Protocol\HTTPS\HTTPS as HTTPSProtocol;

use GI\REST\Route\Segmented\Behaviour\Constraint\Constraints;

use GI\REST\Route\Segmented\CLI\CLI as SegmentedCLI;

use GI\REST\Route\Segmented\UriPath\UriPath;
use GI\REST\Route\Segmented\UriPath\Advanced\Delete\Delete as UriPathWithMethodDelete;
use GI\REST\Route\Segmented\UriPath\Advanced\Get\Get as UriPathWithMethodGet;
use GI\REST\Route\Segmented\UriPath\Advanced\Post\Post as UriPathWithMethodPost;
use GI\REST\Route\Segmented\UriPath\Advanced\Put\Put as UriPathWithMethodPut;

use GI\REST\Route\Segmented\Host\Host as SegmentedHost;
use GI\REST\Route\Segmented\Host\Advanced\HTTP\HTTP as HostWithHTTP;
use GI\REST\Route\Segmented\Host\Advanced\HTTPS\HTTPS as HostWithHTTPS;

use GI\REST\Route\Chain\CLI\AndChain as CLIAndChain;
use GI\REST\Route\Chain\CLI\OrChain as CLIOrChain;
use GI\REST\Route\Chain\Web\AndChain as WebAndChain;
use GI\REST\Route\Chain\Web\OrChain as WebOrChain;


use GI\REST\Route\RouteInterface;

use GI\REST\Route\Simple\Method\Delete\DeleteInterface as DeleteMethodInterface;
use GI\REST\Route\Simple\Method\Get\GetInterface as GetMethodInterface;
use GI\REST\Route\Simple\Method\Post\PostInterface as PostMethodInterface;
use GI\REST\Route\Simple\Method\Put\PutInterface as PutMethodInterface;

use GI\REST\Route\Simple\Protocol\HTTP\HTTPInterface as HTTPProtocolInterface;
use GI\REST\Route\Simple\Protocol\HTTPS\HTTPSInterface as HTTPSProtocolInterface;

use GI\REST\Route\Segmented\Behaviour\Constraint\ConstraintsInterface;

use GI\REST\Route\Segmented\CLI\CLIInterface as SegmentedCLIInterface;

use GI\REST\Route\Segmented\UriPath\UriPathInterface;
use GI\REST\Route\Segmented\UriPath\Advanced\Delete\DeleteInterface as UriPathWithMethodDeleteInterface;
use GI\REST\Route\Segmented\UriPath\Advanced\Get\GetInterface as UriPathWithMethodGetInterface;
use GI\REST\Route\Segmented\UriPath\Advanced\Post\PostInterface as UriPathWithMethodPostInterface;
use GI\REST\Route\Segmented\UriPath\Advanced\Put\PutInterface as UriPathWithMethodPutInterface;

use GI\REST\Route\Segmented\Host\HostInterface as SegmentedHostInterface;
use GI\REST\Route\Segmented\Host\Advanced\HTTP\HTTPInterface as HostWithHTTPInterface;
use GI\REST\Route\Segmented\Host\Advanced\HTTPS\HTTPSInterface as HostWithHTTPSInterface;

use GI\REST\Route\Chain\CLI\AndChainInterface as CLIAndChainInterface;
use GI\REST\Route\Chain\CLI\OrChainInterface as CLIOrChainInterface;
use GI\REST\Route\Chain\Web\AndChainInterface as WebAndChainInterface;
use GI\REST\Route\Chain\Web\OrChainInterface as WebOrChainInterface;

/**
 * Class Factory
 * @package GI\REST\Route\Factory
 *
 * @method DeleteMethodInterface createDeleteMethod()
 * @method GetMethodInterface createGetMethod()
 * @method PostMethodInterface createPostMethod()
 * @method PutMethodInterface createPutMethod()
 *
 * @method HTTPProtocolInterface createHTTPProtocol()
 * @method HTTPSProtocolInterface createHTTPSProtocol()
 *
 * @method ConstraintsInterface createConstraints()
 *
 * @method SegmentedCLIInterface createCLI(string $template, ConstraintsInterface $constraints = null)
 *
 * @method UriPathInterface createUriPath(string $template, ConstraintsInterface $constraints = null)
 * @method UriPathWithMethodDeleteInterface createUriPathWithMethodDelete(string $template, ConstraintsInterface $constraints = null)
 * @method UriPathWithMethodGetInterface createUriPathWithMethodGet(string $template, ConstraintsInterface $constraints = null)
 * @method UriPathWithMethodPostInterface createUriPathWithMethodPost(string $template, ConstraintsInterface $constraints = null)
 * @method UriPathWithMethodPutInterface createUriPathWithMethodPut(string $template, ConstraintsInterface $constraints = null)
 *
 * @method SegmentedHostInterface createHost(string $template, ConstraintsInterface $constraints = null)
 * @method HostWithHTTPInterface createHostWithHTTP(string $template, ConstraintsInterface $constraints = null)
 * @method HostWithHTTPSInterface createHostWithHTTPS(string $template, ConstraintsInterface $constraints = null)
 *
 * @method CLIAndChainInterface createCLIAndChain()
 * @method CLIOrChainInterface createCLIOrChain()
 * @method WebAndChainInterface createWebAndChain()
 * @method WebOrChainInterface createWebOrChain()
 */
class Factory extends AbstractFactory implements FactoryInterface
{
    /**
     * Factory constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        $this->getTemplateClasses()->add(RouteInterface::class);

        $this->setNamed('DeleteMethod', DeleteMethod::class)
            ->setNamed('GetMethod', GetMethod::class)
            ->setNamed('PostMethod', PostMethod::class)
            ->setNamed('PutMethod', PutMethod::class)

            ->setNamed('HTTPProtocol', HTTPProtocol::class)
            ->setNamed('HTTPSProtocol', HTTPSProtocol::class)

            ->set(Constraints::class, null, false)

            ->set(SegmentedCLI::class)

            ->set(UriPath::class)
            ->setNamed('UriPathWithMethodDelete',UriPathWithMethodDelete::class)
            ->setNamed('UriPathWithMethodGet',UriPathWithMethodGet::class)
            ->setNamed('UriPathWithMethodPost',UriPathWithMethodPost::class)
            ->setNamed('UriPathWithMethodPut',UriPathWithMethodPut::class)

            ->set(SegmentedHost::class)
            ->setNamed('HostWithHTTP',HostWithHTTP::class)
            ->setNamed('HostWithHTTPS',HostWithHTTPS::class)

            ->setNamed('CLIAndChain',CLIAndChain::class)
            ->setNamed('CLIOrChain',CLIOrChain::class)
            ->setNamed('WebAndChain',WebAndChain::class)
            ->setNamed('WebOrChain',WebOrChain::class);
    }
}