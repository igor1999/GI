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
namespace GI\Component\Authentication\Login\View\Widget;

use GI\DOM\HTML\Element\Hyperlink\HyperlinkInterface;
use GI\DOM\HTML\Element\Div\FloatingLayout\LayoutInterface;

trait ContentsTrait
{
    /**
     * @var string
     */
    private $registerURI = '';

    /**
     * @var string
     */
    private $restorePasswordURI = '';

    /**
     * @var LayoutInterface
     */
    private $container;

    /**
     * @var HyperlinkInterface
     */
    private $loginLink;

    /**
     * @var HyperlinkInterface
     */
    private $registerLink;

    /**
     * @var HyperlinkInterface
     */
    private $restorePasswordLink;


    /**
     * @return string
     */
    public function getRegisterURI()
    {
        return $this->registerURI;
    }

    /**
     * @param string $registerURI
     * @return static
     */
    public function setRegisterURI(string $registerURI)
    {
        $this->registerURI = $registerURI;

        return $this;
    }

    /**
     * @return string
     */
    public function getRestorePasswordURI()
    {
        return $this->restorePasswordURI;
    }

    /**
     * @param string $restorePasswordURI
     * @return static
     */
    public function setRestorePasswordURI(string $restorePasswordURI)
    {
        $this->restorePasswordURI = $restorePasswordURI;

        return $this;
    }

    /**
     * @return LayoutInterface
     */
    public function getContainer()
    {
        return $this->container;
    }

    /**
     * @return HyperlinkInterface
     */
    public function getLoginLink()
    {
        return $this->loginLink;
    }

    /**
     * @return HyperlinkInterface
     */
    public function getRegisterLink()
    {
        return $this->registerLink;
    }

    /**
     * @return HyperlinkInterface
     */
    public function getRestorePasswordLink()
    {
        return $this->restorePasswordLink;
    }
}