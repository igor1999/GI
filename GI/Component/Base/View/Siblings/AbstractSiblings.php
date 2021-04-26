<?php

namespace GI\Component\Base\View\Siblings;

use GI\Pattern\ArrayExchange\ExtractionTrait;

use GI\DOM\HTML\Element\HTMLInterface;
use GI\Component\Base\View\ClientAttributes\ClientAttributesInterface;

abstract class AbstractSiblings implements SiblingsInterface
{
    use ExtractionTrait;


    /**
     * @param HTMLInterface $element
     * @param string $id
     * @return static
     * @throws \Exception
     */
    protected function addGIId(HTMLInterface $element, string $id)
    {
        $element->getAttributes()->setDataAttribute(ClientAttributesInterface::ATTRIBUTE_GI_ID, $id);

        return $this;
    }
}