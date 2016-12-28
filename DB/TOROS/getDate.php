<?php
    //INPUT:船種的的關鍵字
	//PROCSEE:從從船種的關鍵字 QUERY出所有的船次 
	//OUTPUT:JSON格式的船次Table Name
	require_once("DB_config.php");
    require_once("DB_class.php");
	
    $month=$_POST['month'];
	$month = "toros_$month";
	//$moonth="toros_201611";
	
	//$moonth = "KM0909";
	// Use fopen function to open a file
	// connect SQL
	//連線資料庫
	$db = new DB();
    $db->connect_db($_DB['host'], $_DB['username'], $_DB['password'], $_DB['dbname']);
	
	//Query
	//$sqlstr = "show tables from {$_DB['dbname']} like '%$moonth%'";
	$sqlstr = "select distinct Datetime from $month";
    $db->query($sqlstr);

	$rows = array();
	while ($row = $db->fetch_row()){
		//將陣列內容轉存在PHP的array
		$data_array[] = array (
						"0" => $row[0]);
	}
	//print_r($data_array);
	  
	echo json_encode($data_array);

	/*
    while($row = mysql_fetch_array($result)){
        echo $row['Longitude'] . ' ' . $row['Latitude'] . ' ';
    }*/
	
	//echo json_encode($rs);  
	/*
	$rows[] = array("result" => 'This is JSON data');
    $json = json_encode($rows);     
    echo $json;*/
	
?>