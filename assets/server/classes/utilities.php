<?php 
function dump($array) 
{
	foreach($array as $key => $value) 
	{
		if(!is_array($array)) 
		{
			echo "Error: supplied value not an array";
			exit;
		}
		echo $key . " " . $value . "<br />";
	}
}

function rt_date($timestamp, $time = 0) 
{
	if(!$time) 
	{
		return date("d M Y", $timestamp);	
	}
	else 
	{
		return date("d M Y", $timestamp);
	}
}

class echotest 
{
  function echotest() 
  {
    echo "test it";
  }
}
  
function check_isset($id) 
{
  if(isset($id)) 
  {
  	return $id;
  }
  else 
  {
  	return 0;
  }
  	
}
?>