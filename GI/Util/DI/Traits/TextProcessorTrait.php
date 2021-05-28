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

use GI\Util\TextProcessing\MarkupTextProcessor\MarkupTextProcessor;
use GI\Util\TextProcessing\Splitter\Splitter;

use GI\ServiceLocator\ServiceLocatorAwareTrait;

use GI\Util\TextProcessing\MarkupTextProcessor\MarkupTextProcessorInterface;
use GI\Util\TextProcessing\Splitter\SplitterInterface;

trait TextProcessorTrait
{
    /**
     * @var SplitterInterface
     */
    private $misc;


    /**
     * @param string|null $caller
     * @return MarkupTextProcessorInterface
     */
    public function createMarkupTextProcessor(string $caller = null)
    {
        /** @var ServiceLocatorAwareTrait $me */
        $me = $this;

        try {
            $result = $me->getGiServiceLocator()->getDi()->find(
                MarkupTextProcessorInterface::class, $caller
            );
        } catch (\Exception $e) {
            $result = new MarkupTextProcessor();
        }

        return $result;
    }

    /**
     * @param string|null $caller
     * @return SplitterInterface
     */
    public function getSplitter(string $caller = null)
    {
        /** @var ServiceLocatorAwareTrait $me */
        $me = $this;

        try {
            $result = $me->getGiServiceLocator()->getDi()->find(SplitterInterface::class, $caller);
        } catch (\Exception $e) {
            if (!($this->misc instanceof SplitterInterface)) {
                $this->misc = new Splitter();
            }

            $result = $this->misc;
        }

        return $result;
    }
}