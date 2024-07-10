<?php
namespace Emizen\CustomAttribute\Plugin\Category;

class Heading 
{
    
    protected $_request;
    protected $_registry;

    public function __construct(
      \Magento\Framework\App\Request\Http $request,
      \Magento\Framework\Registry $registry,
      \Magento\Framework\UrlInterface $urlInterface
    ) {
        $this->_request = $request;
        $this->_registry = $registry;
        $this->_urlInterface = $urlInterface;
    }


    public function aroundGetPageHeading(\Magento\Theme\Block\Html\Title $subject, $proceed) {


            if($this->_request->getFullActionName() == 'catalog_category_view'){

                $category = $this->_registry->registry('current_category');
                if($category->getCategoryHeading() && $category->getCategoryHeading() != ""){
                  return $category->getCategoryHeading();
                }
                
            }


            $result = $proceed();

            return $result;

            
            
    }


}
