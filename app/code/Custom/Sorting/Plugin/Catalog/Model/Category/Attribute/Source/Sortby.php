<?php
namespace Custom\Sorting\Plugin\Catalog\Model\Category\Attribute\Source;

class Sortby
{
	   /**
		* @param MagentoSortby $subject
		* @param array $result
		* @return array
		*/
		public function afterGetAllOptions(\Magento\Catalog\Model\Category\Attribute\Source\Sortby $subject, array $result): array
		{
		  array_push($result, ['label' => __('Random Products'), 'value' => 'random']);

		  return $result;
		}
}