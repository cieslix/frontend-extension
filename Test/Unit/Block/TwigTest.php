<?php

namespace Creativestyle\FrontendExtension\Test\Unit\Block;

class TwigTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var \Magento\TestFramework\ObjectManager
     */
    private $objectManager;

    /**
     * @var \Creativestyle\ContentConstructorFrontendExtension\Block\Twig
     */
    private $twigBlock;

    public function setUp() {
        $this->objectManager = \Magento\TestFramework\ObjectManager::getInstance();

        $this->twigBlock = $this->objectManager->get(\Creativestyle\FrontendExtension\Block\Twig::class);
    }

    public function testItImplementsBlockInterface() {
        $this->assertInstanceOf(\Magento\Framework\View\Element\BlockInterface::class, $this->twigBlock);
    }

    /**
     * @dataProvider getTitles
     */
    public function testItDisplaysTemplate($title) {
        $locatorStub = $this
            ->getMockBuilder(\Creativestyle\FrontendExtension\Template\Locator::class)
            ->disableOriginalConstructor()
            ->getMock();

        $twigBlock = $this->objectManager->create(
            \Creativestyle\FrontendExtension\Block\Twig::class,
            [
                'locator' => $locatorStub,
                'data' => ['title' => $title]
            ]
        );

        $locatorStub->method('locate')->willReturn(__DIR__.'/assets/template.twig');

        $this->assertEquals($title, $twigBlock->toHtml());
    }
    public static function getTitles() {
        return [
            ['example content'],
            ['another content']
        ];
    }
}