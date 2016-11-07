<?php

require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'abstract.php';

/**
 * php postfinance2xero.php -file exmples/postfinance_export_Transactions_20161106.csv
 */
class PostFinance2Xero extends Shell_Abstract
{
    protected $_includeMage = false;

    const IN_CSV_DELIMITER = ";";
    const IN_CSV_ENCLOSURE = "\"";

    public function run()
    {
        $file = $this->getArg('file');
        $file = realpath($file);

        if (file_exists($file) &&  ($handle = fopen($file, "r")) !== FALSE) {
            //
            // Header rows:
            //
            //Date from:;2016-10-01
            $row = fgetcsv($handle, 10000, self::IN_CSV_DELIMITER, self::IN_CSV_ENCLOSURE);
            $from = ($row !== FALSE ? $row[1] : NULL);
            //Date to:;2016-10-31
            $row = fgetcsv($handle, 10000, self::IN_CSV_DELIMITER, self::IN_CSV_ENCLOSURE);
            $to = ($row !== FALSE ? $row[1] : NULL);
            //Entry type:;All bookings
            $row = fgetcsv($handle, 10000, self::IN_CSV_DELIMITER, self::IN_CSV_ENCLOSURE);
            //Account:;CH9509000000141904295
            $row = fgetcsv($handle, 10000, self::IN_CSV_DELIMITER, self::IN_CSV_ENCLOSURE);
            //Currency:;CHF
            $row = fgetcsv($handle, 10000, self::IN_CSV_DELIMITER, self::IN_CSV_ENCLOSURE);
            //Booking details:;Yes
            $row = fgetcsv($handle, 10000, self::IN_CSV_DELIMITER, self::IN_CSV_ENCLOSURE);
            // Booking date;Notification text;Credit;Debit;Value;Balance
            $row = fgetcsv($handle, 10000, self::IN_CSV_DELIMITER, self::IN_CSV_ENCLOSURE);

            $targetPath = dirname($file) . DIRECTORY_SEPARATOR . "postfinance2xero_{$from}_{$to}.csv";

            $fp = fopen($targetPath, 'w');

            fputcsv($fp, array('*Date','*Amount','Description'));
            while (($row = fgetcsv($handle, 10000, ";")) !== FALSE) {
                if(empty($row[0])) {
                    break;
                }
                $fields['*Date'] = $row[0];
                $fields['*Amount'] = (empty($row[2]) ? $row[3] : $row[2]);
                $fields['Description'] = $row[1];
                fputcsv($fp, $fields);
            }

            fclose($fp);
            fclose($handle);

            echo "Done\n";
        } else {
            echo "--- WRONG PARAMETERS ---\n";
        }
    }
}

$shell = new PostFinance2Xero();
$shell->run();
