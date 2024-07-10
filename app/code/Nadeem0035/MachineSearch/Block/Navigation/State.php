<?php
namespace Nadeem0035\MachineSearch\Block\Navigation;

class State extends \Magento\LayeredNavigation\Block\Navigation\State
{
	public function __construct(
		\Magento\Framework\View\Element\Template\Context $context,
		\Nadeem0035\MachineSearch\Model\Layer\Resolver $layerResolver,
		array $data = []
	) {
		parent::__construct($context, $layerResolver, $data);
    }
}