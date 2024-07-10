<?php

namespace Nadeem0035\ImportData\Model\Config\Source;
use \Magento\ImportExport\Model\Import\ErrorProcessing\ProcessingErrorAggregatorInterface;
class ValidationStrategy implements \Magento\Framework\Option\ArrayInterface
{
    /**
     * Options array
     *
     * @var array
     */
    protected $_options;

    /**
     * Return options array
     *
     * @return array
     */
    public function toOptionArray()
    {
        if (!$this->_options) {
            $this->_options = [
                ['value' => ProcessingErrorAggregatorInterface::VALIDATION_STRATEGY_STOP_ON_ERROR, 'label' => __('Stop on Error')], 
                ['value' => ProcessingErrorAggregatorInterface::VALIDATION_STRATEGY_SKIP_ERRORS, 'label' => __('Skip error entries')], 
            ];
        }

        return $this->_options;
    }
}
