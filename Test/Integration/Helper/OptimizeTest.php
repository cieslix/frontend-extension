<?php

namespace Creativestyle\FrontendExtension\Test\Integration\Helper;

/**
 * @magentoDbIsolation enabled
 * @magentoAppIsolation enabled
 */
class OptimizeTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var \Magento\TestFramework\ObjectManager
     */
    private $objectManager;

    /**
     * @var \Creativestyle\FrontendExtension\Helper\Optimize
     */
    private $optimizeHelper;

    public function setUp()
    {
        $this->objectManager = \Magento\TestFramework\ObjectManager::getInstance();

        $this->optimizeHelper = $this->objectManager->get(\Creativestyle\FrontendExtension\Helper\Optimize::class);
    }

    /**
     * @magentoAppArea frontend
     * @magentoDbIsolation enabled
     * @magentoAppIsolation enabled
     * @magentoConfigFixture current_store google/optimize/optimize_container_id test123
     */
    public function testItReturnCorrectValue()
    {
        $this->assertEquals('test123', $this->optimizeHelper->getOptimizeContainerId());
    }

}