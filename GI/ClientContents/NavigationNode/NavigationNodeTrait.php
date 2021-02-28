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
namespace GI\ClientContents\NavigationNode;

use GI\DOM\HTML\Constants\Constants as HTMLConstants;
use GI\DOM\HTML\Constants\Target as HTMLTargetConstants;

trait NavigationNodeTrait
{
    /**
     * @var string
     */
    private $title = '';

    /**
     * @var string
     */
    private $link = '';

    /**
     * @var string
     */
    private $target = '';


    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return static
     */
    public function setTitle(string $title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return string
     */
    public function getLink()
    {
        return $this->link;
    }

    /**
     * @param string $link
     * @return static
     */
    public function setLink(string $link)
    {
        $this->link = $link;

        return $this;
    }

    /**
     * @return static
     */
    public function setLinkToMock()
    {
        $this->setLink(HTMLConstants::HREF_MOCK);

        return $this;
    }

    /**
     * @return string
     */
    public function hasTarget()
    {
        return !empty($this->target);
    }

    /**
     * @return string
     */
    public function getTarget()
    {
        return $this->target;
    }

    /**
     * @param string $target
     * @return static
     */
    public function setTarget(string $target)
    {
        $this->target = $target;

        return $this;
    }

    /**
     * @return static
     */
    public function setTargetToBlank()
    {
        $this->setTarget(HTMLTargetConstants::BLANK);

        return $this;
    }

    /**
     * @return static
     */
    public function setTargetToSelf()
    {
        $this->setTarget(HTMLTargetConstants::SELF_TARGET);

        return $this;
    }

    /**
     * @return static
     */
    public function setTargetToParent()
    {
        $this->setTarget(HTMLTargetConstants::PARENT_TARGET);

        return $this;
    }

    /**
     * @return static
     */
    public function setTargetToTop()
    {
        $this->setTarget(HTMLTargetConstants::TOP);

        return $this;
    }
}