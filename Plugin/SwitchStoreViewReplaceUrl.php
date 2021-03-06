<?php

namespace Creativestyle\FrontendExtension\Plugin;

class SwitchStoreViewReplaceUrl
{
    /**
     * @var \Magento\Framework\App\Request\Http
     */
    private $request;

    /**
     * @var \Magento\Framework\Url\Helper\Data
     */
    private $urlHelper;

    /**
     * @var \Creativestyle\FrontendExtension\Service\Store\UrlGenerator
     */
    private $urlGenerator;

    /**
     * @var \Magento\Framework\Data\Helper\PostHelper
     */
    private $postDataHelper;

    public function __construct(
        \Magento\Framework\App\Request\Http $request,
        \Magento\Framework\Url\Helper\Data $urlHelper,
        \Creativestyle\FrontendExtension\Service\Store\UrlGenerator $urlGenerator,
        \Magento\Framework\Data\Helper\PostHelper $postDataHelper
    )
    {
        $this->request = $request;
        $this->urlGenerator = $urlGenerator;
        $this->urlHelper = $urlHelper;
        $this->postDataHelper = $postDataHelper;
    }

    public function aroundGetTargetStorePostData(
        \Magento\Store\Block\Switcher $subject,
        $proceed,
        \Magento\Store\Model\Store $store,
        $data = []
    )
    {
        if($this->request->getFullActionName() != 'cms_page_view'){
            return $proceed($store, $data);
        }

        $newUrl = $this->urlGenerator->replaceCmsPageUrl($this->request->getParam('page_id'), $store->getId(), $this->request->getUriString());

        if(empty($newUrl)){
            return $proceed($store, $data);
        }

        $data[\Magento\Framework\App\ActionInterface::PARAM_NAME_URL_ENCODED] = $this->urlHelper->getEncodedUrl($newUrl);
        $data[\Magento\Store\Api\StoreResolverInterface::PARAM_NAME] = $store->getCode();

        return $this->postDataHelper->getPostData(
            $newUrl,
            $data
        );
    }
}