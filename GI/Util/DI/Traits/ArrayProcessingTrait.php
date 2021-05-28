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
namespace GI\Util\DI\Traits;

use GI\Util\ArrayProcessing\Assoc\Assoc as AssocProcessor;
use GI\Util\ArrayProcessing\Extractor\Extractor;
use GI\Util\ArrayProcessing\Flat\Creator as FlatCreator;
use GI\Util\ArrayProcessing\Flat\Extractor as FlatExtractor;

use GI\ServiceLocator\ServiceLocatorAwareTrait;

use GI\Util\ArrayProcessing\Assoc\AssocInterface as AssocProcessorInterface;
use GI\Util\ArrayProcessing\Extractor\ExtractorInterface;
use GI\Util\ArrayProcessing\Flat\CreatorInterface as FlatCreatorInterface;
use GI\Util\ArrayProcessing\Flat\ExtractorInterface as FlatExtractorInterface;

trait ArrayProcessingTrait
{
    /**
     * @var AssocProcessorInterface
     */
    private $assocProcessor;

    /**
     * @var ExtractorInterface
     */
    private $extractor;

    /**
     * @var FlatCreatorInterface
     */
    private $flatCreator;

    /**
     * @var FlatExtractorInterface
     */
    private $flatExtractor;


    /**
     * @param string|null $caller
     * @return AssocProcessorInterface
     */
    public function getAssocProcessor(string $caller = null)
    {
        /** @var ServiceLocatorAwareTrait $me */
        $me = $this;

        try {
            $result = $me->getGiServiceLocator()->getDi()->find(AssocProcessorInterface::class, $caller);
        } catch (\Exception $e) {
            if (!($this->assocProcessor instanceof AssocProcessorInterface)) {
                $this->assocProcessor = new AssocProcessor();
            }

            $result = $this->assocProcessor;
        }

        return $result;
    }

    /**
     * @param string|null $caller
     * @return ExtractorInterface
     */
    public function getExtractor(string $caller = null)
    {
        /** @var ServiceLocatorAwareTrait $me */
        $me = $this;

        try {
            $result = $me->getGiServiceLocator()->getDi()->find(ExtractorInterface::class, $caller);
        } catch (\Exception $e) {
            if (!($this->extractor instanceof ExtractorInterface)) {
                $this->extractor = new Extractor();
            }

            $result = $this->extractor;
        }

        return $result;
    }

    /**
     * @param string|null $caller
     * @return FlatCreatorInterface
     */
    public function getFlatCreator(string $caller = null)
    {
        /** @var ServiceLocatorAwareTrait $me */
        $me = $this;

        try {
            $result = $me->getGiServiceLocator()->getDi()->find(FlatCreatorInterface::class, $caller);
        } catch (\Exception $e) {
            if (!($this->flatCreator instanceof FlatCreatorInterface)) {
                $this->flatCreator = new FlatCreator();
            }

            $result = $this->flatCreator;
        }

        return $result;
    }

    /**
     * @param string|null $caller
     * @return FlatExtractorInterface
     */
    public function getFlatExtractor(string $caller = null)
    {
        /** @var ServiceLocatorAwareTrait $me */
        $me = $this;

        try {
            $result = $me->getGiServiceLocator()->getDi()->find(FlatExtractorInterface::class, $caller);
        } catch (\Exception $e) {
            if (!($this->flatExtractor instanceof FlatExtractorInterface)) {
                $this->flatExtractor = new FlatExtractor();
            }

            $result = $this->flatExtractor;
        }

        return $result;
    }
}