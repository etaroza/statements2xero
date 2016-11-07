<?php

require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'abstract.php';

/**
 * php litasesis2xero.php -config paysera:visa:eur -file exmples/litas-esis_2016-10-01_2016-10-31.acc
 */
class PaySera2Xero extends Shell_Abstract
{
    protected $_includeMage = false;

    public function run()
    {
        $file = $this->getArg('file');
        $file = realpath($file);

        $config = $this->getArg('config');

        if (file_exists($file) && $config !== FALSE) {
            $targetPath = dirname($file) . DIRECTORY_SEPARATOR . basename($file, ".acc") . ".ofx";

            exec("ofxstatement convert -t {$config} \"{$file}\" \"{$targetPath}\"");

            // We need to get rid of the XML comments because Xero doesn't understand them in the header
            exec("sed -i '' '/<\\!--/d' \"{$targetPath}\"");
            exec("sed -i '' '/-->/d' \"{$targetPath}\"");
        } else {
            echo "--- WRONG PARAMETERS ---\n";
        }
    }
}

$shell = new PaySera2Xero();
$shell->run();
