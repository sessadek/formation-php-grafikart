<?php

var_dump(dirname(__DIR__, 4));
exit;
$file = __DIR__.DIRECTORY_SEPARATOR."demo.txt";
file_put_contents($file, " est ça va ?", FILE_APPEND);
