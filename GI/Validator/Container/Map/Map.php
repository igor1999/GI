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
namespace GI\Validator\Container\Map;

use GI\Validator\AbstractValidator;

use GI\Validator\ValidatorInterface;

class Map extends AbstractValidator implements MapInterface
{
    /**
     * @var ValidatorInterface
     */
    private $validator;

    /**
     * @var array
     */
    private $messages = [];


    /**
     * Map constructor.
     * @param ValidatorInterface $validator
     */
    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    /**
     * @return ValidatorInterface
     */
    public function getValidator()
    {
        return $this->validator;
    }

    /**
     * @return array
     */
    public function getMessages()
    {
        return $this->messages;
    }

    /**
     * @return bool
     * @throws \Exception
     */
    protected function doValidation()
    {
        if (!is_array($this->getSource())) {
            $this->getGiServiceLocator()->throwInvalidTypeException('Validator source', $this->getSource(), 'array');
        }

        $result = true;
        $this->messages = [];

        foreach ($this->getSource() as $key => $value) {
            $param = $this->getValidator()->getValidatedParam() . '[' . $key . ']';
            $this->getValidator()->setValidatedParam($param);

            if (!$this->getValidator()->validate($value)) {
                $result = false;

                $this->messages[$key] = $this->getValidator()->getMessages();

                if ($this->getValidator()->hasBreak()) {
                    break;
                }
            }
        }

        return $result;
    }
}