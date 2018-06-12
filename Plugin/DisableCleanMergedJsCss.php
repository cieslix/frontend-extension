<?php

namespace Creativestyle\FrontendExtension\Plugin;

class DisableCleanMergedJsCss
{
    public function aroundCleanMergedJsCss(\Magento\Framework\View\Asset\MergeService $subject, callable $proceed, ...$args) {
        return null;
    }
}