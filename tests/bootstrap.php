<?php

namespace Heatbeat;

$path = realpath(dirname(__FILE__) . '/../');
set_include_path($path . PATH_SEPARATOR . get_include_path());

require 'lib/Heatbeat/Autoloader.php';
Autoloader::getInstance();