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

$str = '';

$len = mb_strlen($contents);

for($i=$last_pos+1;$i<=$len;$i++){

    $char = mb_substr($contents,$i,1);
    $str .= $char;
    
    if($char=='.' && mb_strlen($str)>=100){
        $str = preg_replace("/\n+/","\n",$str);
        $str = preg_replace("/\t/"," ",$str);
        $str = preg_replace("/\s+/"," ",$str);
        $str = trim($str);
        $str = wordwrap($str,60);
        echo $str.PHP_EOL;
        file_put_contents($folder.'/pos',$i);
        break;
    }
    
}

exec("git add $folder/pos && git commit -m 'Position update' && git push origin master > /dev/null 2>&1 &");