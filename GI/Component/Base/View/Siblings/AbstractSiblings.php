<?php

namespace GI\Component\Base\View\Siblings;

use GI\ServiceLocator\ServiceLocatorAwareTrait;
use GI\Pattern\ArrayExchange\ExtractionTrait;

abstract class AbstractSiblings implements SiblingsInterface
{
    use ServiceLocatorAwareTrait, ExtractionTrait;
}