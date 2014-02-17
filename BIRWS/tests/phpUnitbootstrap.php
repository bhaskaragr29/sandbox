<?php
/**
 * @author    bhaskar
 * @created   Feb 17, 2014 - 4:19:22 PM
 * @encoding  UTF-8
 */

require_once __DIR__ . '/../vendor/autoload.php';

define('DATABASE_PATH', __DIR__ . '/database');
use Symfony\Component\Yaml\Yaml;

define ( 'CONFIG_PATH', __DIR__ . '/../app/config' );

if (! class_exists ( 'Symfony\\Component\\Yaml\\Yaml' )) {
  throw new \RuntimeException ( 'Unable to read yaml as the Symfony Yaml Component is not installed.' );
}
$config = Yaml::parse ( CONFIG_PATH . '/global.yml' );


