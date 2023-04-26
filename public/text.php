<?php

$file = file_get_contents('test.txt');
$wordArray = explode('@',trim($file));
$newString = '';
foreach($wordArray as $key => $value)
{
    //$row = explode(',',$value);
    //if(trim($row[0]) == '' || trim($row[1]) == '')
    //{
       // echo ($key + 3) . "-".$row[0].'-'.$row[1].PHP_EOL;
    //}
	
	$value = explode('#',$value);
	//echo $value[0].PHP_EOL;
	$test_answers = substr_count($value[1],'a)') == 1 && substr_count($value[1],'b)') == 1 && substr_count($value[1],'c)') == 1 && substr_count($value[1],'d)') == 1;
	if(!$test_answers)
		echo "answers in test ".($key+1)." is not valid";
}

if($test_answers)
{
	foreach($wordArray as $key => $value)
    {
		$value = explode('#',$value);
	    echo $value[0].PHP_EOL;
		$value[1] = str_replace('a)',')',$value[1]);
		$value[1] = str_replace('b)',')',$value[1]);
		$value[1] = str_replace('c)',')',$value[1]);
		$value[1] = str_replace('d)',')',$value[1]);
		$answers = explode(')',$value[1]);
		echo trim($answers[1]).PHP_EOL;
		echo trim($answers[2]).PHP_EOL;
		echo trim($answers[3]).PHP_EOL;
		echo trim($answers[4]).PHP_EOL;
		
	}
}

// echo sizeof($wordArray);
// echo $newString;

// file_put_contents('new.csv',$newString);
