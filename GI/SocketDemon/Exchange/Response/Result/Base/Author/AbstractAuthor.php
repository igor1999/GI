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
namespace GI\SocketDemon\Exchange\Response\Result\Base\Author;

use GI\SocketDemon\Exchange\Response\Result\Base\AbstractResult;

use GI\Identity\IdentityInterface;

abstract class AbstractAuthor extends AbstractResult implements AuthorInterface
{
    /**
     * @var string
     */
    private $author = '';


    /**
     * AbstractAuthorResult constructor.
     */
    public function __construct()
    {
        $this->setAuthorFromSession();
    }

    /**
     * @extract
     * @return string
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * @param string $author
     * @return static
     */
    public function setAuthor(string $author)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * @return static
     */
    public function setAuthorFromSession()
    {
        try {
            /** @var IdentityInterface $identity */
            $identity = $this->getGiServiceLocator()->getDependency(IdentityInterface::class);
            $this->setAuthor($identity->getLogin());
        } catch (\Exception $e) {}

        return $this;
    }
}