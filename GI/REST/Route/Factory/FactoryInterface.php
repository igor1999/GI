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

use GI\Pattern\Factory\FactoryInterface as BaseInterface;

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
 * Interface FactoryInterface
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
interface FactoryInterface extends BaseInterface
{

}