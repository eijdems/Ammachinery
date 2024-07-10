<?php

namespace MageBeans\Stocklist\Console\Command;

use MageBeans\Stocklist\Helper\Data;
use Magento\Framework\App\State;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class Download extends Command
{
    const NAME_ARGUMENT = "name";
    const NAME_OPTION = "option";
    /**
     * @var Data
     */
    private $helper;
    private $state;

    public function __construct(
        Data $helper,
        State $state
    ) {
        $this->helper = $helper;
        $this->state = $state;
        parent::__construct($data = null);
    }
    /**
     * {@inheritdoc}
     */
    protected function execute(
        InputInterface $input,
        OutputInterface $output
    ) {
        $this->state->setAreaCode(\Magento\Framework\App\Area::AREA_FRONTEND);
        $name = $input->getArgument(self::NAME_ARGUMENT);
        $option = $input->getOption(self::NAME_OPTION);
        $fileName = $this->helper->getData();
        if ($this->helper->isEnable()) {
            //$fileName = $this->helper->getData();
            //$fileName = '/var/www/html/var/stocklist/stocklist 17122020.pdf';
            //$this->helper->sendData($fileName);
        }
    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setName("magebeans_stocklist:download");
        $this->setDescription("");
        $this->setDefinition([
            new InputArgument(self::NAME_ARGUMENT, InputArgument::OPTIONAL, "Name"),
            new InputOption(self::NAME_OPTION, "-a", InputOption::VALUE_NONE, "Option functionality")
        ]);
        parent::configure();
    }
}
