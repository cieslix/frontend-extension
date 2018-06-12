<?php

namespace Creativestyle\FrontendExtension\Block\Product\ProductList;

class Toolbar extends \Magento\Catalog\Block\Product\ProductList\Toolbar
{
    public function getLimit()
    {
        return 10000;
    }

    public function isExpanded()
    {
        return true;
    }
}