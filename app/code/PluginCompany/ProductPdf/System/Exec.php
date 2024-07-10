<?php
/**
 * Created by:  Milan Simek
 * Company:     Plugin Company
 *
 * LICENSE: http://plugin.company/docs/magento-extensions/magento-extension-license-agreement
 *
 * YOU WILL ALSO FIND A PDF COPY OF THE LICENSE IN THE DOWNLOADED ZIP FILE
 *
 * FOR QUESTIONS AND SUPPORT
 * PLEASE DON'T HESITATE TO CONTACT US AT:
 *
 * SUPPORT@PLUGIN.COMPANY
 */
namespace PluginCompany\ProductPdf\System;

class Exec
{
    private $phpExecutableList =
        array(
            'php-cli',
            'php5-cli',
            'php5.6-cli',
            'php7-cli',
            'php7.0-cli',
            'php7.1-cli',
            'php7.2-cli',
            'php'
        );

    private $execMethodName;

    public function isExecEnabled()
    {
        return (bool)$this->getExecMethodName();
    }

    private function getExecMethodName()
    {
        if (!$this->hasExecMethodName()) {
            $this->initExecMethodName();
        }
        return $this->execMethodName;
    }

    private function hasExecMethodName()
    {
        return isset($this->execMethodName);
    }

    private function initExecMethodName()
    {
        if(@exec('echo EXEC') == 'EXEC'){
            return $this->execMethodName = 'exec';
        }
        if(@shell_exec('echo EXEC') == "EXEC\n"){
            return $this->execMethodName = 'shell_exec';
        }
        $this->execMethodName = false;
    }

    public function execute($command, $background = false)
    {
        if($background){
            $background = ' > /dev/null 2>&1 &';
        }
        if(!$this->getExecMethodName()){
            throw new \Exception("Exec is disabled. Please enable exec or shell_exec in php.ini.");
        }
        if($this->getExecMethodName() == 'exec'){
//            $this->logDebug('exec: ' . $command.$background);
            @exec($command . $background);
            return;
        }
        if($this->getExecMethodName() == 'shell_exec'){
//            $this->logDebug('shell_exec: ' . $command.$background);
            return @shell_exec($command . $background);
        }
//        $this->logDebug('NO EXEC');
        return $this;
    }

    public function executePHP($command, $background = '')
    {
        return $this->execute($this->getPhpExecutable() . ' ' . $command, $background);
    }

    public function getPhpExecutable()
    {
        if(!empty(PHP_BINARY)) {
            $executable = preg_replace('/-cgi$/', '', PHP_BINARY);
            if(file_exists($executable)) {
                return $executable;
            }
        }
        foreach($this->phpExecutableList as $executable) {
            if($this->getExecutable($executable)){
                return $this->getExecutable($executable);
            }
        }
        return 'php';
    }

    private function getExecutable($executable)
    {
        $path = $this->execute('which ' . $executable);
        if(is_array($path)){
            $path = $path[0];
        }
        if(strpos($path, '/') === 0){
            return $path;
        }
        return false;
    }

//    private function logDebug($message)
//    {
//        \Magento\Framework\App\ObjectManager::getInstance()
//            ->get(\Psr\Log\LoggerInterface::class)->critical($message);
//    }

}