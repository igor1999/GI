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
namespace GI\Email;

use GI\Email\Body\Body;
use GI\Email\Header\Header;

use GI\ServiceLocator\ServiceLocatorAwareTrait;

use GI\Email\Body\BodyInterface;
use GI\Email\Header\HeaderInterface;

class Email implements EmailInterface
{
    use ServiceLocatorAwareTrait;


    /**
     * @var HeaderInterface
     */
    private $header;

    /**
     * @var BodyInterface
     */
    private $body;


    /**
     * Email constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        $this->header = $this->getGiServiceLocator()->getDependency(HeaderInterface::class, Header::class);
        $this->body   = $this->getGiServiceLocator()->getDependency(BodyInterface::class, Body::class);
    }

    /**
     * @return HeaderInterface
     */
    public function getHeader()
    {
        return $this->header;
    }

    /**
     * @return BodyInterface
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @return static
     * @throws \Exception
     */
    public function validate()
    {
        $this->getHeader()->validate();

        return $this;
    }

    /**
     * @return bool
     * @throws \Exception
     */
    public function send()
    {
        $this->validate();

        $compose = \imap_mail_compose($this->getHeader()->extract(), $this->getBody()->extract());
        $mail    = str_replace("\r",'', $compose);

        return \imap_mail($this->getHeader()->getTo()->toString(), $this->getHeader()->getSubject(),' ', $mail);
    }

    /**
     * @return static
     */
    public function reset()
    {
        $this->getHeader()->reset();
        $this->getBody()->clean();

        return $this;
    }
}