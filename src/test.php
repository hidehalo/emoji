<?php
/**
 * Created by PhpStorm.
 * User: TianChen
 * Date: 17/1/7
 * Time: 20:35
 */
require_once __DIR__.'/Psr4Autoloader.php';
Psr4Autoloader::addNamespace('\Hidehalo\Emoji',__DIR__);
Psr4Autoloader::register();

use Hidehalo\Emoji\Core;

$core = new Core();
$rs = $core->filter('😁 😁 😁😁😁 😁😁 😁😁');
var_dump($rs);die;