<?php
/**
 * @author    Bhaskar Agarwal <bhaskar.agarwal@paddypower.com>
 * @created   Feb 17, 2014 - 9:55:18 AM
 * @encoding  UTF-8
 */
require_once __DIR__ . '/../app/bootstrap.php';

use Symfony\Component\Console\Application;
use Guzzle\Http\Client;
use \Doctrine\DBAL\Configuration;
use \Doctrine\DBAL\DriverManager;
use BIR\Component\LiveCalendar\Command\LiveCalendarCron;

$liveCron = new LiveCalendarCron ();

$liveCron->setDatabase ( DriverManager::getConnection ( $db ['database'], new Configuration () ) );
$console = new Application ( 'BIR_WS Live Calendar', '1.0' );
$console->add ( $liveCron );
$console->run ();

