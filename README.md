Magento 2 Extension to prevent that Blocks with a TTL got rendered
-----

Magento does replace the output HTML of blocks with a TTL with an ESI-Tag for the Varnish Cache.

In this case Magento wasted time to render the block, because the output of the block will be never used.

So this module will prevent rendering blocks with a TTL to increase the TTFB (Time to the first byte).

## Install

```bash
compose require webidea24/magento-module-prevent-rendering-esi-blocks
bin/magento setup:upgrade
```
