<?php

namespace MageBeans\Stocklist\Model\Config\Source;

/**
 * @api
 * @since 100.0.2
 */
class Cycle implements \Magento\Framework\Option\ArrayInterface
{
    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
        return [
            ['value' => '0 0 * * 0', 'label' => __('Each Week')],
            ['value' => '30 1 1,15 * *', 'label' => __('Each 2 Week')]
        ];
    }

    /**
     * Get options in "key-value" format
     *
     * @return array
     */
    public function toArray()
    {
        return [
            '0 0 * * 0' => __('Each Week'),
            '30 1 1,15 * *' => __('Each 2 Week')
        ];
    }
}
