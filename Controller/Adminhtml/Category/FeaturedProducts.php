<?php

namespace Creativestyle\FrontendExtension\Controller\Adminhtml\Category;


abstract class FeaturedProducts extends \Magento\Backend\App\Action
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'Creativestyle_FrontendExtension::item_list';


}