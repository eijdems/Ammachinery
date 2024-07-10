<?php
namespace Nadeem0035\MachineSearch\Block;

class Navigation extends \Magento\LayeredNavigation\Block\Navigation
{

    protected $filterList;
    protected $_catalogLayer;

	public function __construct(
		\Magento\Framework\View\Element\Template\Context $context,
		\Nadeem0035\MachineSearch\Model\Layer\Resolver $layerResolver,
        \Nadeem0035\MachineSearch\Model\Layer\FilterList $filterList,
		\Magento\Catalog\Model\Layer\AvailabilityFlagInterface $visibilityFlag,
		array $data = []
	) {
        $this->filterList = $filterList;
        $this->_catalogLayer = $layerResolver->get();
		parent::__construct($context, $layerResolver, $filterList,
			$visibilityFlag);
	}

    public function getFilters()
    {
        return $this->filterList->getFilters($this->_catalogLayer);
    }
}