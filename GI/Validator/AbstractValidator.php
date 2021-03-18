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
namespace GI\Validator;

use GI\Validator\I18n\DefaultMessages;
use GI\Validator\I18n\Glossary\Glossary;

use GI\ServiceLocator\ServiceLocatorAwareTrait;

use GI\Validator\I18n\Glossary\GlossaryInterface;

abstract class AbstractValidator implements ValidatorInterface
{
    use ServiceLocatorAwareTrait;


    const PARSE_MESSAGE_PLACEHOLDER_TEMPLATE = '%%%s%%';

    const PARSE_MESSAGE_DESCRIPTOR           = 'message';


    /**
     * @var bool
     */
    private $required = false;

    /**
     * @var bool
     */
    private $break = false;

    /**
     * @var string
     */
    private $validatedParam = '';

    /**
     * @var mixed
     */
    private $source;

    /**
     * @var bool
     */
    private $exists = true;

    /**
     * @var bool
     */
    private $result = true;


    /**
     * @return bool
     */
    public function isRequired()
    {
        return $this->required;
    }

    /**
     * @param bool $required
     * @return static
     */
    public function setRequired(bool $required)
    {
        $this->required = $required;

        return $this;
    }

    /**
     * @return boolean
     */
    public function hasBreak()
    {
        return $this->break;
    }

    /**
     * @param boolean $break
     * @return static
     */
    public function setBreak(bool $break)
    {
        $this->break = (bool)$break;

        return $this;
    }

    /**
     * @message
     * @return string
     */
    public function getValidatedParam()
    {
        return $this->validatedParam;
    }

    /**
     * @param string $validatedParam
     * @return static
     */
    public function setValidatedParam(string $validatedParam)
    {
        $this->validatedParam = $validatedParam;

        return $this;
    }

    /**
     * @message
     * @return mixed
     */
    public function getSource()
    {
        return $this->source;
    }

    /**
     * @param mixed $source
     * @return static
     */
    protected function setSource($source)
    {
        $this->source = $source;

        return $this;
    }

    /**
     * @return bool
     */
    public function isExists()
    {
        return $this->exists;
    }

    /**
     * @param bool $exists
     * @return static
     */
    protected function setExists(bool $exists)
    {
        $this->exists = $exists;

        return $this;
    }

    /**
     * @return bool
     */
    public function getResult()
    {
        return $this->result;
    }

    /**
     * @param bool $result
     * @return static
     */
    protected function setResult(bool $result)
    {
        $this->result = (bool)$result;

        return $this;
    }

    /**
     * @return static
     */
    public function cleanResult()
    {
        $this->setResult(true);

        return $this;
    }

    /**
     * @param mixed $value
     * @return bool
     */
    public function validate($value)
    {
        $this->setSource($value)
            ->setExists(true)
            ->setResult($this->doValidation());

        return $this->getResult();
    }

    /**
     * @return bool
     */
    public function validateIfNotExists()
    {
        $this->setSource(null)->setExists(false)->setResult(!$this->required);

        return $this->getResult();
    }

    /**
     * @return bool
     */
    abstract protected function doValidation();

    /**
     * @return string
     * @throws \Exception
     */
    protected function getNoExistenceMessage()
    {
        $message = $this->giTranslate(
            GlossaryInterface::class, Glossary::class,DefaultMessages::EXISTENCE
        );

        return $this->insertParamsInMessage($message);
    }

    /**
     * @param string $message
     * @return string
     * @throws \Exception
     */
    protected function insertParamsInMessage(string $message)
    {
        return  $this->giGetClassMeta()->getMethods()->parse(
            $this,
            $message,
            static::PARSE_MESSAGE_DESCRIPTOR,
            static::PARSE_MESSAGE_PLACEHOLDER_TEMPLATE
        );
     }

    /**
     * @return array
     */
    public function getMessagesFlat()
    {
        return is_array($this->getMessages())
            ? $this->giGetFlatCreator()->create($this->getMessages())
            : [$this->getMessages()];
    }

    /**
     * @return string
     */
    public function getFirstMessage()
    {
        $flatMessages = $this->getMessagesFlat();

        return array_shift($flatMessages);
    }

    /**
     * @return array
     * @throws \Exception
     */
    public function getMessagesProParam()
    {
        if (is_array($this->getMessages())) {
            $messages = [];

            $flatArray = $this->giGetFlatCreator()->createWithKeySeparatorPoint($this->getMessages());

            foreach ($flatArray as $key => $message) {
                $param = $this->createParamName($key);

                if (empty($param)) {
                    $messages[] = $message;
                } else {
                    if (!array_key_exists($param, $messages)) {
                        $messages[$param] = [];
                    }
                    $messages[$param][] = $message;
                }
            }
        } elseif (is_string($this->getMessages())) {
            $messages = [$this->getMessages()];
        } else {
            $messages = null;
            $this->giThrowInvalidTypeException('Messages', '[validator messages]', 'array or string');
        }

        return $messages;
    }

    /**
     * @param string $key
     * @return string
     */
    protected function createParamName(string $key)
    {
        $keys = explode('.', $key);
        $f = function($key)
        {
            return !is_numeric($key);
        };
        $keys = array_filter($keys, $f);

        $name = '';

        foreach ($keys as $index => $value) {
            if ($index == 0) {
                $name .= $value;
            } else {
                $name .= '[' . $value . ']';
            }
        }

        return $name;
    }
}