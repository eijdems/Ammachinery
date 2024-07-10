<?php
/**
 * Copyright © 2013-2017 Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace MageBeans\Pageimage\Model\Cms\Page;

use Magento\Cms\Model\ResourceModel\Page\CollectionFactory;
use Magento\Framework\App\Request\DataPersistorInterface;

/**
 * Class DataProvider
 */
class DataProvider extends \Magento\Cms\Model\Page\DataProvider
{

    /**
     * Get data
     *
     * @return array
     */
     public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }
        $items = $this->collection->getItems();
        /** @var $page \Magento\Cms\Model\Page */
        foreach ($items as $page) {
            $this->loadedData[$page->getId()] = $page->getData();
            if(!empty($this->loadedData[$page->getId()]['extra_image'])){
                $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
                $storeManager = $objectManager->get('Magento\Store\Model\StoreManagerInterface');
                $currentStore = $storeManager->getStore();
                $media_url=$currentStore->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);

                $image_name=$this->loadedData[$page->getId()]['extra_image'];
                unset($this->loadedData[$page->getId()]['extra_image']);
                $this->loadedData[$page->getId()]['extra_image'][0]['name']=$image_name;
                $this->loadedData[$page->getId()]['extra_image'][0]['url']= $media_url."magebeans/image/".$image_name;
            }
        }

        $data = $this->dataPersistor->get('cms_page');


        if (!empty($data)) {
            $page = $this->collection->getNewEmptyItem();

            $page->setData($data);
            $this->loadedData[$page->getId()] = $page->getData();
            $this->dataPersistor->clear('cms_page');
        }
        /* For Modify  You custom image field data */

       /* if(!empty($this->loadedData[1]['extra_image'])){
            $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
            $storeManager = $objectManager->get('Magento\Store\Model\StoreManagerInterface');
            $currentStore = $storeManager->getStore();
            $media_url=$currentStore->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);

            $image_name=$this->loadedData[1]['extra_image'];
            unset($this->loadedData[1]['extra_image']);
            $this->loadedData[1]['extra_image'][0]['name']=$image_name;
            $this->loadedData[1]['extra_image'][0]['url']=$media_url."magebeans/image/".$image_name;
        }*/
        return $this->loadedData;
    }
}