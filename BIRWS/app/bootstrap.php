<?php
/**
 * @author    "Bhaskar Agarwal <bhaskar.agarwal@paddypower.com>"
 * @created   Feb 12, 2014 - 1:33:02 PM
 * @encoding  UTF-8
 */
require_once __DIR__ . '/../vendor/autoload.php';

use Symfony\Component\Yaml\Yaml;

define ( 'CONFIG_PATH', __DIR__ . '/config' );

if (! class_exists ( 'Symfony\\Component\\Yaml\\Yaml' )) {
	throw new \RuntimeException ( 'Unable to read yaml as the Symfony Yaml Component is not installed.' );
}
$db = Yaml::parse ( CONFIG_PATH . '/database.yml' );
$config = Yaml::parse ( CONFIG_PATH . '/global.yml' );
