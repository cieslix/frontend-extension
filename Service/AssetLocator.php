<?php

namespace Creativestyle\FrontendExtension\Service;

interface AssetLocator
{
    /**
     * Gets URL of an asset
     * @param string $assetLocation
     * @return mixed
     */
    public function getUrl(string $assetLocation);
}