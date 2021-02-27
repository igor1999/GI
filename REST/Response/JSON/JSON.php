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
namespace GI\REST\Response\JSON;

use GI\REST\Response\AbstractResponse;
use GI\FileSystem\ContentTypes;

class JSON extends AbstractResponse implements JSONInterface
{
    /**
     * @var mixed
     */
    private $data;


    /**
     * JSON constructor.
     * @param mixed $data
     */
    public function __construct($data)
    {
        $this->setData($data);

        parent::__construct();
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param mixed $data
     * @return static
     */
    public function setData($data)
    {
        $this->data = $data;

        return $this;
    }

    /**
     * @return static
     */
    protected function setRequiredHeaders()
    {
        $this->getHeaders()->addContentType(ContentTypes::JSON);

        return $this;
    }

    /**
     * @return static
     * @throws \Exception
     */
    public function dispatchBody()
    {
        echo $this->giCreateJsonEncoder()
            ->setFlagJsonHexTag(true)
            ->setFlagJsonHexAmp(true)
            ->setFlagJsonHexApos(true)
            ->setFlagJsonHexQuot(true)
            ->setFlagJsonPrettyPrint(true)
            ->encode($this->getData());

        return $this;
    }
}