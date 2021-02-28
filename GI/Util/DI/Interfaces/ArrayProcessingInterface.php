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
namespace GI\Util\DI\Interfaces;

use GI\Util\ArrayProcessing\Assoc\AssocInterface as AssocProcessorInterface;
use GI\Util\ArrayProcessing\Extractor\ExtractorInterface;
use GI\Util\ArrayProcessing\Flat\CreatorInterface as FlatCreatorInterface;
use GI\Util\ArrayProcessing\Flat\ExtractorInterface as FlatExtractorInterface;

interface ArrayProcessingInterface
{
    /**
     * @param string|null $caller
     * @return AssocProcessorInterface
     */
    public function getAssocProcessor(string $caller = null);

    /**
     * @param string|null $caller
     * @return ExtractorInterface
     */
    public function getExtractor(string $caller = null);

    /**
     * @param string|null $caller
     * @return FlatCreatorInterface
     */
    public function getFlatCreator(string $caller = null);

    /**
     * @param string|null $caller
     * @return FlatExtractorInterface
     */
    public function getFlatExtractor(string $caller = null);
}
