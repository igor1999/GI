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
namespace GI\Util\TextProcessing\XML\Version;

use GI\Util\TextProcessing\XML\Version\Context\ContextInterface;

trait VersionTrait
{
    /**
     * @var string
     */
    private $xmlVersion = VersionInterface::DEFAULT_VERSION;


    /**
     * @return string
     */
    public function getXmlVersion()
    {
        return $this->xmlVersion;
    }

    /**
     * @param string $xmlVersion
     * @return static
     */
    public function setXmlVersion(string $xmlVersion)
    {
        $this->xmlVersion = $xmlVersion;

        return $this;
    }

    /**
     * @return static
     * @throws \Exception
     */
    protected function initXMLVersionByContext()
    {
        try {
            /** @var ContextInterface $context */
            $context  = $this->giGetDi(ContextInterface::class);

            $this->setXmlVersion($context->getVersion());
        } catch (\Exception $e) {
            $this->setXmlVersion(VersionInterface::DEFAULT_VERSION);
        }

        return $this;
    }


}