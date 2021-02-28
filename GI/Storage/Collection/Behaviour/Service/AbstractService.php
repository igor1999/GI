<?php

namespace GI\Storage\Collection\Behaviour\Service;

use GI\ServiceLocator\ServiceLocatorAwareTrait;

use GI\Storage\Collection\Behaviour\Option\OptionInterface;

abstract class AbstractService implements ServiceInterface
{
    use ServiceLocatorAwareTrait;


    /**
     * @var OptionInterface
     */
    private $option;


    /**
     * AbstractService constructor.
     * @param OptionInterface|null $option
     */
    public function __construct(OptionInterface $option = null)
    {
        if ($option instanceof OptionInterface) {
            $this->option = $option;
        } else {
            $this->option = $this->createDefaultOption();
        }
    }

    /**
     * @return OptionInterface
     */
    abstract protected function createDefaultOption();

    /**
     * @return OptionInterface
     */
    protected function getOption()
    {
        return $this->option;
    }
}