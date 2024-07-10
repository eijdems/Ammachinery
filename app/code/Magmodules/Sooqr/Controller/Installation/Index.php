<?php
/**
 * Copyright © 2019 Magmodules.eu. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Magmodules\Sooqr\Controller\Installation;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\Result\JsonFactory;
use Magmodules\Sooqr\Helper\Feed;

/**
 * Class Index
 *
 * @package Magmodules\Sooqr\Controller\Installation
 */
class Index extends Action
{

    /**
     * @var Feed
     */
    private $feedHelper;
    /**
     * @var JsonFactory
     */
    private $resultJsonFactory;

    /**
     * Index constructor.
     *
     * @param Context     $context
     * @param Feed        $feedHelper
     * @param JsonFactory $resultJsonFactory
     */
    public function __construct(
        Context $context,
        Feed $feedHelper,
        JsonFactory $resultJsonFactory
    ) {
        $this->feedHelper = $feedHelper;
        $this->resultJsonFactory = $resultJsonFactory;
        parent::__construct($context);
    }

    /**
     * @return mixed
     */
    public function execute()
    {
        if ($feed = $this->feedHelper->getInstallation()) {
            $result = $this->resultJsonFactory->create();
            return $result->setData($feed);
        }
    }
}
