<?php
if(empty($argv[1])){
    die("No folder has been provided!\n");
}

$folder = $argv[1];

if(!is_dir($folder)){
    die("Invalid folder!\n");
}

$contents = file_get_contents("$folder/ebook.txt");

if(!file_exists($folder.'/pos')){
    touch($folder.'/pos');
}

$last_pos = (int) file_get_contents($folder.'/pos');

$len = mb_strlen($contents);

echo round(100 * $last_pos / $len, 2).'%';
echo PHP_EOL;

/*
len = 100%
last_pos = x

x*len = 100 * last_pos
x = 100 * last_pos / len

*/