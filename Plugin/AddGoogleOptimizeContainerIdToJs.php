<?php

namespace Creativestyle\FrontendExtension\Plugin;

class AddGoogleOptimizeContainerIdToJs
{
    /**
     * @var \Creativestyle\FrontendExtension\Helper\Optimize
     */
    protected $optimizeHelper;

    public function __construct(
        \Creativestyle\FrontendExtension\Helper\Optimize $optimizeHelper
    )
    {
        $this->optimizeHelper = $optimizeHelper;
    }

    public function afterGetPageTrackingData(\Magento\GoogleAnalytics\Block\Ga $subject, $result) {
        $result['optimizeContainerId'] = $this->optimizeHelper->getOptimizeContainerId();

        return $result;
    }
}