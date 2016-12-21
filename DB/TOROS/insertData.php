<?php
    //INPUT:船次的資料夾路徑
	//PROCSEE:將CSV格式資料寫入資料庫
	//OUTPUT:無
	$dbname = "toros";
	$tname = "TOTL_TORO_2016_11_01_0000"; //小寫
	$path = "G:\\海洋工作\\資料庫\\DATA\\TOROS\\11\\$tname.tuv";
	//$Date = date("Y-m-d H:i:s",strtotime("2016-11-01"));
	//$Time = "00:00:00";
	
	//echo $path;
	
	$path =  iconv('UTF-8','Big5', $path);
	// Use fopen function to open a file
	$file = fopen($path, "r");
	// connect SQL
	$link=mysql_connect("localhost","root","711113") or die("連接失敗");
	mysql_select_db($dbname,$link);
	mysql_query("SET NAMES utf8");

	echo "connection!!";

	$sqlStr="insert into $tname(ID, Datetime, Longitude, Latitude, Ucomp, Vcomp, Velocity) values";

	$count = 0;
	// Read the file line by line until the end
	//while (($data = fgets($file, 1000)) !== FALSE){
	while (($data = fgets($file)) !== false){
		//$data = fgets($file, 1000);
		//echo $data;
		
		if(substr($data , 0, 1) == "%"){
			continue;
		}
		$data = trim($data);    //delete space
		$data = preg_replace("/\s(?=\s)/","\\1",$data);
		$dataArray = explode(" ", $data);
		//echo $dataArray[0];
		$Longitude = $dataArray[0];
		$Latitude = $dataArray[1];
		$Ucomp = $dataArray[2];
		$Vcomp = $dataArray[3];
		$Velocity = $dataArray[12];
		$Velocity = $dataArray[12];
		//echo $Longitude . "<br />" . $Voyage . "<br />\n" ;

		//insert to DB
		$sqlStr.=" ($count, '2016-11-01 00:00:00', $Longitude, $Latitude, $Ucomp, $Vcomp, $Velocity),";
		$count = $count + 1;
		//if ($count >100)
		//  break;
	}
	$sqlStr = substr($sqlStr,0,-1);  //delete last char
	echo $sqlStr;
	mysql_query($sqlStr);
	echo "Successfu!";
	// Close the file that no longer in use
	fclose($file);
?>

