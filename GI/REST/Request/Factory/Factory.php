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

use GI\Pattern\Factory\AbstractFactory;

use GI\REST\Request\Cookie\Cookie;
use GI\REST\Request\Files\Files;
use GI\REST\Request\Headers\Headers;
use GI\REST\Request\Body\Body;
use GI\REST\Request\Post\Post;
use GI\REST\Request\Query\Query;
use GI\REST\Request\Server\Server;

use GI\REST\Request\Upload\Collection\Collection as UploadCollection;


use GI\REST\Request\RequestTreeInterface;

use GI\REST\Request\Cookie\CookieInterface;
use GI\REST\Request\Files\FilesInterface;
use GI\REST\Request\Headers\HeadersInterface;
use GI\REST\Request\Body\BodyInterface;
use GI\REST\Request\Post\PostInterface;
use GI\REST\Request\Query\QueryInterface;
use GI\REST\Request\Server\ServerInterface;

use GI\REST\Request\Upload\Collection\CollectionInterface as UploadCollectionInterface;

/**
 * Class Factory
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
class Factory extends AbstractFactory implements FactoryInterface
{
    /**
     * Factory constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        $this->getTemplateClasses()
            ->add(RequestTreeInterface::class)
            ->add(ServerInterface::class)
            ->add(HeadersInterface::class)
            ->add(BodyInterface::class);

        $this->setPrefixToGet()
            ->setCached(true)
            ->set(Cookie::class)
            ->set(Files::class)
            ->set(Headers::class)
            ->set(Body::class)
            ->set(Post::class)
            ->set(Query::class)
            ->set(Server::class);
    }

    /**
     * @param string|null $caller
     * @return UploadCollectionInterface
     * @throws \Exception
     */
    public function createUpload(string $caller = null)
    {
        try {
            $result = $this->getGiServiceLocator()->getDi()->find(
                UploadCollectionInterface::class, $caller
            );
        } catch (\Exception $e) {
            $result = new UploadCollection();
        }

        $result->hydrate($this->getFiles()->extract());

        return $result;
    }

    /**
     * @return static
     */
    public function close()
    {
        $this->getCookie()->close();
        $this->getFiles()->close();
        $this->getHeaders()->close();
        $this->getBody()->close();
        $this->getPost()->close();
        $this->getQuery()->close();
        $this->getServer()->close();

        return $this;
    }
}