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

use GI\Component\Base\View\Widget\WidgetInterface as BaseInterface;
use GI\ClientContents\BreadCrumbs\Track\TrackInterface as BreadCrumbsTrackInterface;
use GI\DOM\HTML\Element\Hyperlink\HyperlinkInterface;

/**
 * Interface WidgetInterface
 * @package GI\Component\BreadCrumbs\Base\View
 *
 * @method BreadCrumbsTrackInterface getBreadCrumbsTrack()
 * @method WidgetInterface setBreadCrumbsTrack(BreadCrumbsTrackInterface $breadCrumbsTrack)
 */
interface WidgetInterface extends BaseInterface
{
    /**
     * @param string $id
     * @return bool
     */
    public function hasNode(string $id);

    /**
     * @param string $id
     * @return HyperlinkInterface
     * @throws \Exception
     */
    public function getNode(string $id);

    /**
     * @return HyperlinkInterface[]
     */
    public function getNodes();
}