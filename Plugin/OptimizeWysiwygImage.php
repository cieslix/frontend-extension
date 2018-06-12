<?php

namespace Creativestyle\FrontendExtension\Plugin;

class OptimizeWysiwygImage
{
    /**
     * @var \Creativestyle\FrontendExtension\Service\Image\Optimizer
     */
    private $imageOptimizer;

    public function __construct(\Creativestyle\FrontendExtension\Service\Image\Optimizer $imageOptimizer)
    {
        $this->imageOptimizer = $imageOptimizer;
    }

    public function beforeResizeFile(\Magento\Cms\Model\Wysiwyg\Images\Storage $subject, $source, $keepRation = true) {
        //$this->imageOptimizer->optimize($source);
    }
}