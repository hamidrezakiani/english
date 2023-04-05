<?php

$file = file_get_contents('new.csv');
$wordArray = explode(PHP_EOL,trim($file));
$newString = '';
foreach($wordArray as $key => $value)
{
    $row = explode(',',$value);
    if(trim($row[0]) == '' || trim($row[1]) == '')
    {
        echo ($key + 3) . "-".$row[0].'-'.$row[1].PHP_EOL;
    }

}

// echo sizeof($wordArray);
// echo $newString;

// file_put_contents('new.csv',$newString);
