<?php
\Magento\Framework\Component\ComponentRegistrar::register(
    \Magento\Framework\Component\ComponentRegistrar::MODULE,
    'Creativestyle_FrontendExtension',
    __DIR__
);

\Magento\Framework\Component\ComponentRegistrar::register(
    \Magento\Framework\Component\ComponentRegistrar::LIBRARY,
    'ps/image-optimizer',
    __DIR__.'/../../ps/image-optimizer/src'
);
