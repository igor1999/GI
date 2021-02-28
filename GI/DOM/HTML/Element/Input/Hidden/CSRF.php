<?php

namespace GI\DOM\HTML\Element\Input\Hidden;

use GI\Security\CSRF\CSRF as CsrfGenerator;

use GI\Security\CSRF\CSRFInterface as CsrfGeneratorInterface;

class CSRF extends Hidden implements CSRFInterface
{
    const NAME = 'gi-csrf-token';


    /**
     * @var CsrfGeneratorInterface
     */
    private $csrfGenerator;


    /**
     * @return CsrfGeneratorInterface|mixed
     * @throws \Exception
     */
    protected function getCsrfGenerator()
    {
        if (!($this->csrfGenerator instanceof CsrfGeneratorInterface)) {
            $this->csrfGenerator = $this->giGetDi(CsrfGeneratorInterface::class, CsrfGenerator::class);
        }

        return $this->csrfGenerator;
    }

    /**
     * @return string
     * @throws \Exception
     */
    public function toString()
    {
        $this->getName()->setItems([static::NAME]);
        $this->getAttributes()->setValue($this->giCreateSecureCSRF()->generate()->getToken());

        return parent::toString();
    }
}