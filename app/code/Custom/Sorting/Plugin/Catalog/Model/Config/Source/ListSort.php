<?php
namespace Custom\Sorting\Plugin\Catalog\Model\Config\Source;

class ListSort
{
		/**
		* @param MagentoListSort $subject
		* @param array $result
		* @return array
		*/
		public function afterToOptionArray(\Magento\Catalog\Model\Config\Source\ListSort $subject, array $result): array
		{
		  array_push($result, ['label' => __('Random Products'), 'value' => 'random']);

		  return $result;
		}
}