<?php
namespace Emizen\Synchannel\Ui\Component\Listing\Column;

use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;

class CustomButton extends Column
{
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        array $components = [],
        array $data = []
    ) {
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as &$item) {
                // Add your button logic here
                $item[$this->getData('name')] = '<button type="button" class="action-default scalable add" data-url="' . $this->getUrl() . '"><span>' . __('Your Button Label') . '</span></button>';
            }
        }

        return $dataSource;
    }
}
