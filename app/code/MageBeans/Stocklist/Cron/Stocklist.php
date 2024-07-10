<?php

namespace MageBeans\Stocklist\Cron;

use MageBeans\Stocklist\Helper\Data;

class Stocklist
{
    protected $logger;

    public function __construct(
        Data $helper,
        \Psr\Log\LoggerInterface $loggerInterface
    ) {
        $this->helper = $helper;
        $this->logger = $loggerInterface;
    }

    public function execute()
    {
        if ($this->helper->isEnable()) {
            $this->helper->sendData($this->helper->getData());
        }
        //php bin/magento cron:run --group="magebeans_stocklist_cron_group"
        //$this->logger->debug('MageBeans\Stocklist\Cron\Stocklist');
    }
}
