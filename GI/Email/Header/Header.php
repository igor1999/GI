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

use GI\Email\Header\Address\Address;
use GI\Email\Header\Address\AddressList;

use GI\ServiceLocator\ServiceLocatorAwareTrait;

use GI\Email\Header\Address\AddressListInterface;
use GI\Email\Header\Address\AddressInterface;
use GI\REST\Response\Header\Collection\CollectionInterface as CustomHeadersInterface;

class Header implements HeaderInterface
{
    use ServiceLocatorAwareTrait;


    const DATE_FORMAT = 'Y-m-d H:i:s';


    /**
     * @var AddressListInterface
     */
    private $remail;

    /**
     * @var AddressListInterface
     */
    private $returnPath;

    /**
     * @var \DateTime
     */
    private $date;

    /**
     * @var AddressInterface
     */
    private $from;

    /**
     * @var AddressListInterface
     */
    private $replayTo;

    /**
     * @var string
     */
    private $inReplayTo = '';

    /**
     * @var string
     */
    private $subject = '';

    /**
     * @var AddressListInterface
     */
    private $to;

    /**
     * @var AddressListInterface
     */
    private $cc;

    /**
     * @var AddressListInterface
     */
    private $bcc;

    /**
     * @var string
     */
    private $messageId = '';

    /**
     * @var CustomHeadersInterface
     */
    private $customHeaders;


    /**
     * Header constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        $this->remail        = $this->giGetDi(AddressListInterface::class, AddressList::class);
        $this->returnPath    = $this->giGetDi(AddressListInterface::class, AddressList::class);
        $this->replayTo      = $this->giGetDi(AddressListInterface::class, AddressList::class);
        $this->to            = $this->giGetDi(AddressListInterface::class, AddressList::class);
        $this->cc            = $this->giGetDi(AddressListInterface::class, AddressList::class);
        $this->bcc           = $this->giGetDi(AddressListInterface::class, AddressList::class);
        $this->customHeaders = $this->giGetResponseFactory()->getHeaderFactory()->createCollection();
    }

    /**
     * @return AddressListInterface
     */
    public function getRemail()
    {
        return $this->remail;
    }

    /**
     * @return AddressListInterface
     */
    public function getReturnPath()
    {
        return $this->returnPath;
    }

    /**
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param \DateTime $date
     * @return static
     */
    public function setDate(\DateTime $date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * @param string $dateString
     * @return static
     * @throws \Exception
     */
    public function setDateFromString(string $dateString)
    {
        $this->date = new \DateTime(strtotime($dateString));

        return $this;
    }

    /**
     * @return AddressInterface
     * @throws \Exception
     */
    public function getFrom()
    {
        if (!($this->from instanceof AddressInterface)) {
            $this->giThrowNotSetException('From address');
        }

        return $this->from;
    }

    /**
     * @param string $email
     * @param string $name
     * @return static
     * @throws \Exception
     */
    public function setFrom(string $email, string $name = '')
    {
        $this->from = $this->giGetDi(AddressInterface::class, Address::class, [$email, $name]);

        return $this;
    }

    /**
     * @return AddressListInterface
     */
    public function getReplayTo()
    {
        return $this->replayTo;
    }

    /**
     * @return string
     */
    public function getInReplayTo()
    {
        return $this->inReplayTo;
    }

    /**
     * @param string $inReplayTo
     * @return static
     */
    public function setInReplayTo(string $inReplayTo)
    {
        $this->inReplayTo = $inReplayTo;

        return $this;
    }

    /**
     * @return string
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * @param string $subject
     * @return static
     */
    public function setSubject(string $subject)
    {
        $this->subject = $subject;

        return $this;
    }

    /**
     * @return AddressListInterface
     */
    public function getTo()
    {
        return $this->to;
    }

    /**
     * @return AddressListInterface
     */
    public function getCc()
    {
        return $this->cc;
    }

    /**
     * @return AddressListInterface
     */
    public function getBcc()
    {
        return $this->bcc;
    }

    /**
     * @return string
     */
    public function getMessageId()
    {
        return $this->messageId;
    }

    /**
     * @param string $messageId
     * @return static
     */
    public function setMessageId(string $messageId)
    {
        $this->messageId = $messageId;

        return $this;
    }

    /**
     * @return CustomHeadersInterface
     */
    public function getCustomHeaders()
    {
        return $this->customHeaders;
    }

    /**
     * @return static
     * @throws \Exception
     */
    public function validate()
    {
        $this->getFrom();

        $this->getTo()->validateIfNotEmpty();

        return $this;
    }

    /**
     * @return array
     * @throws \Exception
     */
    public function extract()
    {
        $result = [
            self::PROPERTY_REMAIL         => $this->getRemail()->toString(),
            self::PROPERTY_RETURN_PATH    => $this->getReturnPath()->toString(),
            self::PROPERTY_DATE           => ($this->date instanceof \DateTime)
                                                ? $this->date->format(static::DATE_FORMAT)
                                                : '',
            self::PROPERTY_FROM           => $this->getFrom()->toString(),
            self::PROPERTY_REPLY_TO       => $this->getReplayTo()->toString(),
            self::PROPERTY_IN_REPLY_TO    => $this->inReplayTo,
            self::PROPERTY_SUBJECT        => $this->subject,
            self::PROPERTY_TO             => $this->getTo()->toString(),
            self::PROPERTY_CC             => $this->getCc()->toString(),
            self::PROPERTY_BCC            => $this->getBcc()->toString(),
            self::PROPERTY_MESSAGE_ID     => $this->messageId,
            self::PROPERTY_CUSTOM_HEADERS => $this->getCustomHeaders()->getHeadersAsString(),
        ];

        return array_filter($result);
    }

    /**
     * @return static
     */
    public function reset()
    {
        $this->getRemail()->clean();
        $this->getReturnPath()->clean();
        $this->setDate(new \DateTime());
        $this->from = null;
        $this->getReplayTo()->clean();
        $this->setInReplayTo('')
            ->setSubject('');
        $this->getTo()->clean();
        $this->getCc()->clean();
        $this->getBcc()->clean();
        $this->setMessageId('');
        $this->getCustomHeaders()->clean();

        return $this;
    }
}