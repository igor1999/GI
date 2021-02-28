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
namespace GI\CLI\Input;

use GI\ServiceLocator\ServiceLocatorAwareTrait;

use GI\Validator\ValidatorInterface;

abstract class AbstractInput implements InputInterface
{
    use ServiceLocatorAwareTrait;


    /**
     * @var string
     */
    private $prompt = '';

    /**
     * @var string
     */
    private $input = '';

    /**
     * @var ValidatorInterface
     */
    private $validator;


    /**
     * @return string
     */
    public function getPrompt()
    {
        return $this->prompt;
    }

    /**
     * @param string $prompt
     * @return static
     */
    public function setPrompt(string $prompt)
    {
        $this->prompt = $prompt;

        return $this;
    }

    /**
     * @return static
     */
    protected function printPrompt()
    {
        if (!empty($this->prompt)) {
            echo $this->prompt;
        }

        return $this;
    }

    /**
     * @return string
     */
    public function getInput()
    {
        return $this->input;
    }

    /**
     * @param string $input
     * @return static
     */
    protected function setInput($input)
    {
        $this->input = $input;

        return $this;
    }

    /**
     * @return ValidatorInterface
     */
    public function getValidator()
    {
        return $this->validator;
    }

    /**
     * @param ValidatorInterface|null $validator
     * @return static
     */
    public function setValidator(ValidatorInterface $validator = null)
    {
        $this->validator = $validator;

        return $this;
    }

    /**
     * @return static
     * @throws \Exception
     */
    protected function handleFail()
    {
        if (($this->getValidator() instanceof ValidatorInterface) && !$this->getValidator()->validate($this->input)) {
            foreach ($this->getValidator()->getMessagesFlat() as $message) {
                echo $message, PHP_EOL;
            }

            $this->giThrowCommonException($this->getValidator()->getFirstMessage());
        }

        return $this;
    }
}