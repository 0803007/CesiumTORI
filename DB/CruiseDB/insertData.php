<?php
    //INPUT:船次的資料夾路徑
	//PROCSEE:將CSV格式資料寫入資料庫
	//OUTPUT:無
	$dbname = "CruiseDB";
	$tname = "RR1016"; //小寫
	$path = "G:\\海洋工作\\資料庫\\航次\\CruiseDB\\nav\\FOR\\$tname.nav";
	//echo $path;
	
	$path =  iconv('UTF-8','Big5', $path);
	// Use fopen function to open a file
	$file = fopen($path, "r");
	// connect SQL
	$link=mysql_connect("localhost","root","711113") or die("連接失敗");
	mysql_select_db($dbname,$link);
	mysql_query("SET NAMES utf8");

	echo "connection!!";

	$sqlStr="insert into $tname(ID,Longitude,Latitude,Date,Time,Voyage) values";

	$count = 0;
	// Read the file line by line until the end
	while (($data = fgetcsv($file, 1000, " ")) !== FALSE){
			$Longitude = $data[0];
			$Latitude = $data[1];
			$Date = $data[2];
			$Time = $data[3];
			$Voyage = $data[4];
			//echo $Longitude . "<br />" . $Voyage . "<br />\n" ;

			//insert to DB
			$sqlStr.=" ($count,$Longitude,$Latitude ,$Date,$Time,'$Voyage'),";
			$count = $count + 1;
			//if ($count >1000)
			//   break;
	}
	$sqlStr = substr($sqlStr,0,-1);  //delete last char
	echo $sqlStr;
	mysql_query($sqlStr);
	echo "Successfu!";
	// Close the file that no longer in use
	fclose($file);
?>

