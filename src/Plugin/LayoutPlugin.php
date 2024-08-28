<?php

declare(strict_types=1);

namespace Webidea24\VarnishPreventRenderEsiBlock\Plugin;

use Magento\Framework\View\Element\AbstractBlock;
use Magento\Framework\View\Layout;
use Magento\PageCache\Model\Config;

class LayoutPlugin
{
    private bool $_isEnabled;

    public function __construct(
        private readonly Config $config
    )
    {
    }

    public function aroundRenderNonCachedElement(Layout $subject, callable $callable, string $name): ?string
    {
        $block = $subject->getBlock($name);

        if ($block instanceof AbstractBlock && is_numeric($block->getTtl()) && ((int)$block->getTtl()) > 0 && $this->isVarnishEnabled()) {
            return ''; // esi tag will be added by event observer `core_layout_render_element`
        }

        return $callable($name);
    }

    private function isVarnishEnabled(): bool
    {
        if (!isset($this->_isEnabled)) {
            $this->_isEnabled = $this->config->isEnabled() && $this->config->getType() === Config::VARNISH;
        }

        return $this->_isEnabled;
    }
}
