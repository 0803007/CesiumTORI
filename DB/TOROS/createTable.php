<?php
	//INPUT:DB名稱,Table名稱
	//PROCSEE:建立資料庫與資料表
	//OUTPUT:無
	header("Content-Type:text/html; charset=utf-8");

	$dbname = "smallsun_toros";
	$tname = "toros_201611";

	$link=mysql_connect("10.110.21.71","smallsun","711113") or die("連接失敗");

	//刪除舊資料庫
	//if (mysql_query("DROP DATABASE IF EXISTS $dbname"))
	//	echo "1.資料庫已刪除<br>";

	//建立資料庫
	if(mysql_query("create database $dbname"))
		echo "資料庫已建立<br>";
	else
		echo "資料庫已存在<br>";
	
    //建立資料表

	$sqlstr="use $dbname";
	mysql_query($sqlstr);
	$sqlstr="create table $tname(ID int NOT NULL AUTO_INCREMENT PRIMARY KEY, Datetime datetime, Longitude float, Latitude float, Ucomp float, Vcomp float, Velocity float, INDEX (datetime))";
	mysql_query($sqlstr) or die("資料表建立失敗");
	echo "資料表建立成功<br>";

?>
