<?php

namespace Nadeem0035\CategoryAttribute\Block;
use \Magento\Framework\View\Element\Template\Context;
use \Magento\Cms\Model\Template\FilterProvider;

class Display extends \Magento\Framework\View\Element\Template
{

    private $_objectManager;
    private $_filterProvider;

    public function __construct(Context $context,\Magento\Framework\ObjectManagerInterface $objectmanager,FilterProvider $filterProvider)
    {
        parent::__construct($context);
        $this->_objectManager = $objectmanager;
        $this->_filterProvider = $filterProvider;
    }

    public function getCustomSidebarContent()
    {
        $category = $this->_objectManager->get('Magento\Framework\Registry')->registry('current_category');//get current category
        $content = $category->getData('custom_sidebar_content');
        return $this->_filterProvider->getPageFilter()->filter($content);
    }
}