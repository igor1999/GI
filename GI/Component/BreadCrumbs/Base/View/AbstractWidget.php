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
namespace GI\Component\BreadCrumbs\Base\View;

use GI\Component\Base\View\Widget\AbstractWidget as Base;

use GI\ClientContents\BreadCrumbs\Track\TrackInterface as BreadCrumbsTrackInterface;
use GI\ClientContents\BreadCrumbs\Node\NodeInterface as BreadCrumbsNodeInterface;
use GI\DOM\HTML\Element\Hyperlink\HyperlinkInterface;
use GI\Component\BreadCrumbs\Base\View\Context\ContextInterface;

abstract class AbstractWidget extends Base implements WidgetInterface
{
    const CLIENT_CSS = 'gi-bread-crumbs';


    const ATTRIBUTE_NODE_ID = 'node-id';


    /**
     * @var BreadCrumbsTrackInterface
     */
    private $breadCrumbsTrack;

    /**
     * @var HyperlinkInterface[]
     */
    private $nodes = [];


    /**
     * @return ResourceRendererInterface
     */
    abstract protected function getResourceRenderer();

    /**
     * @return BreadCrumbsTrackInterface
     */
    public function getBreadCrumbsTrack()
    {
        return $this->breadCrumbsTrack;
    }

    /**
     * @param BreadCrumbsTrackInterface $breadCrumbsTrack
     * @return static
     */
    public function setBreadCrumbsTrack(BreadCrumbsTrackInterface $breadCrumbsTrack)
    {
        $this->breadCrumbsTrack = $breadCrumbsTrack;

        return $this;
    }

    /**
     * @validate
     * @throws \Exception
     */
    protected function validateBreadCrumbsTrack()
    {
        if (!($this->breadCrumbsTrack instanceof BreadCrumbsTrackInterface)) {
            $this->giThrowNotSetException('Bread crumbs track');
        }
    }

    /**
     * @return ContextInterface
     */
    abstract protected function getContext();

    /**
     * @param string $id
     * @return bool
     */
    public function hasNode(string $id)
    {
        return isset($this->nodes[$id]);
    }

    /**
     * @param string $id
     * @return HyperlinkInterface
     * @throws \Exception
     */
    public function getNode(string $id)
    {
        if (!$this->hasNode($id)) {
            $this->giThrowNotInScopeException($id);
        }

        return $this->nodes[$id];
    }

    /**
     * @return HyperlinkInterface[]
     */
    public function getNodes()
    {
        return $this->nodes;
    }

    /**
     * @create
     * @return static
     * @throws \Exception
     */
    protected function createLinks()
    {
        $lastIndex = $this->getBreadCrumbsTrack()->getLength();

        foreach ($this->getBreadCrumbsTrack()->getNodes() as $index => $item) {
            $this->nodes[$item->getId()] = $this->createLink($item, ($index == $lastIndex));
        }

        return $this;
    }

    /**
     * @param BreadCrumbsNodeInterface $item
     * @param bool $last
     * @return HyperlinkInterface
     * @throws \Exception
     */
    protected function createLink(BreadCrumbsNodeInterface $item, bool $last)
    {
        $link = $this->giGetDOMFactory()->createHyperlink($item->getLink(), $item->getTitle());

        if ($last && !$this->getContext()->isLastItemIsLink()) {
            $link->setHrefToMock();
        }

        if ($item->hasTarget()) {
            $link->setTarget($item->getTarget());
        }

        $link->getAttributes()->setDataAttribute(static::ATTRIBUTE_NODE_ID, $item->getId());

        return $link;
    }
}