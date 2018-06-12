<?php

namespace Creativestyle\FrontendExtension\Service\Image;

interface Optimizer
{
    /**
     * Optimizes image
     * @param $filePath
     * @return mixed
     */
    public function optimize($filePath);
}