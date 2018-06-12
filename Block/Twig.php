<?php

namespace Creativestyle\FrontendExtension\Block;

class Twig extends \Magento\Framework\View\Element\Template implements \Magento\Framework\View\Element\BlockInterface
{
    /**
     * @var \Creativestyle\ContentConstructorFrontendExtension\Template\Twig
     */
    private $twig;
    /**
     * @var \Creativestyle\ContentConstructorFrontendExtension\Template\Locator
     */
    private $locator;

    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Creativestyle\FrontendExtension\Template\Twig $twig,
        \Creativestyle\FrontendExtension\Template\Locator $locator,
        array $data = []
    )
    {
        parent::__construct($context, $data);

        $this->twig = $twig;
        $this->locator = $locator;
    }

    /**
     * Produce and return block's html output
     *
     * @return string
     */
    public function toHtml()
    {
        return $this->twig->render(
            $this->locator->locate($this->getTemplate()),
            $this->_data
        );
    }
}