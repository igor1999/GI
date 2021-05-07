<?php

namespace GI\Component\Table\ViewModel\Paging;

use GI\Component\Paging\Base\ViewModel\ViewModelInterface as PagingViewModelInterface;

interface PagingAwareInterface
{
    /**
     * @extract
     * @return PagingViewModelInterface
     */
    public function getPaging();
}