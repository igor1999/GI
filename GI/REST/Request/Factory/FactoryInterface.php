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
namespace GI\REST\Request\Factory;

use GI\Pattern\Factory\FactoryInterface as BaseInterface;

use GI\REST\Request\Cookie\CookieInterface;
use GI\REST\Request\Files\FilesInterface;
use GI\REST\Request\Headers\HeadersInterface;
use GI\REST\Request\Body\BodyInterface;
use GI\REST\Request\Post\PostInterface;
use GI\REST\Request\Query\QueryInterface;
use GI\REST\Request\Server\ServerInterface;

use GI\REST\Request\Upload\Collection\CollectionInterface as UploadCollectionInterface;

/**
 * Interface FactoryInterface
 * @package GI\REST\Request\Factory
 *
 * @method CookieInterface getCookie()
 * @method FilesInterface getFiles()
 * @method HeadersInterface getHeaders()
 * @method BodyInterface getBody()
 * @method PostInterface getPost()
 * @method QueryInterface getQuery()
 * @method ServerInterface getServer()
 */
interface FactoryInterface extends BaseInterface
{
    /**
     * @param string|null $caller
     * @return UploadCollectionInterface
     * @throws \Exception
     */
    public function createUpload(string $caller = null);

    /**
     * @return static
     */
    public function close();
}