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
namespace GI\Email\Header;

use GI\Email\Header\Address\AddressListInterface;
use GI\Email\Header\Address\AddressInterface;
use GI\REST\Response\Header\Collection\CollectionInterface as CustomHeadersInterface;
use GI\Pattern\ArrayExchange\ExtractionInterface;

interface HeaderInterface extends  ExtractionInterface
{
    const PROPERTY_REMAIL         = 'remail';

    const PROPERTY_RETURN_PATH    = 'return_path';

    const PROPERTY_DATE           = 'date';

    const PROPERTY_FROM           = 'from';

    const PROPERTY_REPLY_TO       = 'reply_to';

    const PROPERTY_IN_REPLY_TO    = 'in_reply_to';

    const PROPERTY_SUBJECT        = 'subject';

    const PROPERTY_TO             = 'to';

    const PROPERTY_CC             = 'cc';

    const PROPERTY_BCC            = 'bcc';

    const PROPERTY_MESSAGE_ID     = 'message_id';

    const PROPERTY_CUSTOM_HEADERS = 'custom_headers';


    /**
     * @return AddressListInterface
     */
    public function getRemail();

    /**
     * @return AddressListInterface
     */
    public function getReturnPath();

    /**
     * @return \DateTime
     */
    public function getDate();

    /**
     * @param \DateTime $date
     * @return static
     */
    public function setDate(\DateTime $date);

    /**
     * @param string $dateString
     * @return static
     * @throws \Exception
     */
    public function setDateFromString(string $dateString);

    /**
     * @return AddressInterface
     * @throws \Exception
     */
    public function getFrom();

    /**
     * @param string $email
     * @param string $name
     * @return static
     * @throws \Exception
     */
    public function setFrom(string $email, string $name = '');

    /**
     * @return AddressListInterface
     */
    public function getReplayTo();

    /**
     * @return string
     */
    public function getInReplayTo();

    /**
     * @param string $inReplayTo
     * @return static
     */
    public function setInReplayTo(string $inReplayTo);

    /**
     * @return string
     */
    public function getSubject();

    /**
     * @param string $subject
     * @return static
     */
    public function setSubject(string $subject);

    /**
     * @return AddressListInterface
     */
    public function getTo();

    /**
     * @return AddressListInterface
     */
    public function getCc();

    /**
     * @return AddressListInterface
     */
    public function getBcc();

    /**
     * @return string
     */
    public function getMessageId();

    /**
     * @param string $messageId
     * @return static
     */
    public function setMessageId(string $messageId);

    /**
     * @return CustomHeadersInterface
     */
    public function getCustomHeaders();

    /**
     * @return static
     * @throws \Exception
     */
    public function validate();

    /**
     * @return array
     * @throws \Exception
     */
    public function extract();

    /**
     * @return static
     */
    public function reset();
}