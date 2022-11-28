<?php

set_time_limit(0);

use app\config\Config;
use app\MicroVisor;
use LucidFrame\Console\ConsoleTable;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use app\Helper;

require_once __DIR__ . '/../vendor/autoload.php';

$conf = require __DIR__ . '/../config/main.php';
$config = new Config($conf);

$logger = new Logger('visor');
$logger->pushHandler(new StreamHandler(__DIR__ . '/../log/app.log'));

$visor = new MicroVisor($config, $logger);

while (true) {
    $table = new ConsoleTable();
    $visor->exec();
    echo "\033[2J";
    $table->setHeaders([]);
    $table->hideBorder();
    foreach ($visor->getRunner()->getInfo() as $serviceName => $data) {
        $start = Helper::getMin($data['items'], 'start');
        $stop = Helper::getMax($data['items'], 'stop');
        $start = Helper::getDate($start, 'H:i:s');
        $stop = Helper::getDate($stop, 'H:i:s');

        $table->addRow([$serviceName, $data['count'], '-', $start, $stop]);
        foreach ($data['items'] as $pid => $val) {
            $table->addRow([
                '-',
                '-',
                $pid,
                Helper::getDate($val['start'] ?? null, 'H:i:s'),
                Helper::getDate($val['stop'] ?? null, 'H:i:s'),
            ]);
        }
    }
    $table->display();
    usleep($config->getTimeout() * 1000000);
}
