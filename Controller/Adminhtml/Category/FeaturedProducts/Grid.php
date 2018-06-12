<?php

namespace Creativestyle\FrontendExtension\Controller\Adminhtml\Category\FeaturedProducts;

class Grid extends \Creativestyle\FrontendExtension\Controller\Adminhtml\Category\FeaturedProducts
{
    /**
     * @var \Magento\Framework\Controller\Result\RawFactory
     */
    protected $resultRawFactory;

    /**
     * @var \Magento\Framework\View\LayoutFactory
     */
    protected $layoutFactory;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Controller\Result\RawFactory $resultRawFactory,
        \Magento\Framework\View\LayoutFactory $layoutFactory
    )
    {
        parent::__construct($context);
        $this->resultRawFactory = $resultRawFactory;
        $this->layoutFactory = $layoutFactory;
    }

    public function execute()
    {
        $resultRaw = $this->resultRawFactory->create();

        return $resultRaw->setContents(
            $this->layoutFactory->create()->createBlock(
                'Creativestyle\FrontendExtension\Block\Adminhtml\Category\Tab\FeaturedProducts',
                'category.featured.products.grid'
            )->toHtml()
        );
    }


}