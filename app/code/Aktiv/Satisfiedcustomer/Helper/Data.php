<?php 
 
namespace Aktiv\Satisfiedcustomer\Helper;
 
class Data extends  \Magento\Framework\App\Helper\AbstractHelper
{
    protected $collection;
 
     public function __construct(
        \Aktiv\Satisfiedcustomer\Model\Contact $collection
    ) {
        $this->collection = $collection;
    }
    public function getCollectiondata()
    {
        return $this->collection->getCollection();
    }
 
}