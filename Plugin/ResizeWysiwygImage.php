<?php

namespace Creativestyle\FrontendExtension\Plugin;

use Magento\Framework\App\Filesystem\DirectoryList;

class ResizeWysiwygImage
{

    /**
     * @var \Creativestyle\FrontendExtension\Service\Image\Resizer
     */
    private $resizer;

    public function __construct(
        \Creativestyle\FrontendExtension\Service\Image\Resizer $resizer
    )
    {
        $this->resizer = $resizer;
    }

    public function beforeResizeFile(\Magento\Cms\Model\Wysiwyg\Images\Storage $subject, $source, $keepRation = true)
    {
        $this->resizer->createThumbs($source);

        return [$source, $keepRation];
    }

}