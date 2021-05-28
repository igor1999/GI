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
     * @var string|\Closure
     */
    private $prompt = '';

    /**
     * @var int
     */
    private $repeat = 1;

    /**
     * @var int
     */
    private $attempt = 1;

    /**
     * @var string
     */
    private $input = '';

    /**
     * @var ValidatorInterface
     */
    private $validator;


    /**
     * @return string|\Closure
     */
    public function getPrompt()
    {
        return $this->prompt;
    }

    /**
     * @param string|\Closure $prompt
     * @return static
     * @throws \Exception
     */
    public function setPrompt($prompt = '')
    {
        if (!is_string($prompt) && !($prompt instanceof \Closure)) {
            $this->getGiServiceLocator()->throwInvalidTypeException('Prompt', gettype($prompt), 'string or Closure');
        }

        $this->prompt = $prompt;

        return $this;
    }

    /**
     * @return int
     */
    public function getRepeat()
    {
        return $this->repeat;
    }

    /**
     * @param int $repeat
     * @return static
     */
    public function setRepeat(int $repeat)
    {
        $this->repeat = $repeat;

        return $this;
    }

    /**
     * @return int
     */
    public function getAttempt()
    {
        return $this->attempt;
    }

    /**
     * @param int $attempt
     * @return static
     */
    protected function setAttempt(int $attempt)
    {
        $this->attempt = $attempt;

        return $this;
    }

    /**
     * @return static
     */
    protected function incAttempt()
    {
        $this->setAttempt($this->getAttempt() + 1);

        return $this;
    }

    /**
     * @return static
     */
    protected function resetAttempt()
    {
        $this->setAttempt( 1);

        return $this;
    }

    /**
     * @return static
     */
    protected function printPrompt()
    {
        if (!empty($this->prompt)) {
            echo is_string($this->prompt) ? $this->prompt : call_user_func($this->prompt, $this->attempt);
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
    protected function setInput(string $input)
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

            if ($this->repeat <= 0) {
                $this->incAttempt()->read();
            } elseif ($this->repeat > $this->attempt) {
                $this->incAttempt()->read();
            } else {
                $this->resetAttempt();
                $this->getGiServiceLocator()->throwCommonException($this->getValidator()->getFirstMessage());
            }
        } else {
            $this->resetAttempt();
        }

        return $this;
    }
}