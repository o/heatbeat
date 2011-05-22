<?php

require "Symfony/Component/ClassLoader/UniversalClassLoader.php";

use \Symfony\Component\ClassLoader\UniversalClassLoader as Loader;

$loader = new Loader();
$loader->registerNamespaces(array(
    'Symfony\Component' => __DIR__,
    'Rosso' => __DIR__,
        )
);

$loader->register();